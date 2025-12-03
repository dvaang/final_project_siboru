<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();

// =============================
// NOTIFIKASI MANUAL
// =============================
$notif = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == "waiting") {
        $notif = "
        <div class='notif info'>
            <span class='notif-icon'>👋</span>
            <span class='notif-text'>
                Halo Panitia! Booking Anda sedang menunggu persetujuan.
            </span>
            <a href='dashboard.php' class='notif-btn'>Kembali ke Dashboard</a>
        </div>
        ";
    }
}

// =============================
// CEK RUANGAN
// =============================
$selected_ruangan_id = $_GET['ruangan_id'] ?? null;
if (!$selected_ruangan_id) {
    header("Location: dashboard.php");
    exit;
}

// Ambil daftar ruangan
$q = $db->prepare("SELECT * FROM ruangan ORDER BY nama ASC");
$q->execute();
$listRuangan = $q->fetchAll(PDO::FETCH_ASSOC);

// =============================
// PROSES FORM
// =============================
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_pemesan  = $_SESSION['user_name'];
    $email_pemesan = $_SESSION['user_email'];
    $ruangan_id    = $_POST['ruangan_id'];
    $tanggal       = $_POST['tanggal'];
    $jam_mulai     = $_POST['jam_mulai'];
    $jam_selesai   = $_POST['jam_selesai'];
    $kegiatan      = $_POST['kegiatan'];

    if (!isset($_FILES['surat_izin']) || $_FILES['surat_izin']['error'] != 0) {
        $error = "Surat izin wajib diupload!";
    } else {

        // Cek bentrok
        $cek = $db->prepare("
            SELECT * FROM bookings
            WHERE ruangan_id = ?
            AND tanggal = ?
            AND status IN ('diproses','disetujui')
            AND (jam_mulai < ? AND jam_selesai > ?)
        ");
        $cek->execute([$ruangan_id, $tanggal, $jam_selesai, $jam_mulai]);

        if ($cek->rowCount() > 0) {
            $error = "Ruangan bentrok pada jam tersebut!";
        } else {

            $folder = "../upload/";
            if (!file_exists($folder)) mkdir($folder);

            $fileName = time() . "_" . basename($_FILES['surat_izin']['name']);
            move_uploaded_file($_FILES['surat_izin']['tmp_name'], $folder . $fileName);

            $stmt = $db->prepare("
                INSERT INTO bookings 
                (user_id, nama_pemesan, email_pemesan, ruangan_id, tanggal, jam_mulai, jam_selesai, kegiatan, surat_izin, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'diproses', NOW())
            ");

            $stmt->execute([
                $_SESSION['user_id'],
                $nama_pemesan,
                $email_pemesan,
                $ruangan_id,
                $tanggal,
                $jam_mulai,
                $jam_selesai,
                $kegiatan,
                $fileName
            ]);

            $db->prepare("UPDATE ruangan SET status='terbooking' WHERE id=?")->execute([$ruangan_id]);

            // Redirect ke notifikasi
            header("Location: booking.php?ruangan_id=$ruangan_id&msg=waiting");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Ruangan</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .notif {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .notif-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .notif-text {
            flex: 1;
        }
        .notif-btn {
            text-decoration: none;
            background: #3498db;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
        }
        .notif.info {
            background: #e6f0ff;
            border-left: 5px solid #2980b9;
            color: #1f4f8b;
        }
        .notif.error {
            background: #ffecec;
            border-left: 5px solid #c0392b;
            color: #8e2a1f;
        }
        .notif.success {
            background: #e6fff0;
            border-left: 5px solid #27ae60;
            color: #1e7d4f;
        }
    </style>
</head>
<body>

<div class="dashboard">

    <?= $notif ?>

    <?php if ($error): ?>
        <p class="notif error"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p class="notif success"><?= $success ?></p>
    <?php endif; ?>

    <h2>Form Booking Ruangan</h2>

    <form method="POST" enctype="multipart/form-data">

        <label>Nama Pemesan</label>
        <input type="text" readonly value="<?= $_SESSION['user_name'] ?>">

        <label>Email Pemesan</label>
        <input type="email" readonly value="<?= $_SESSION['user_email'] ?>">

        <label>Pilih Ruangan</label>
        <select name="ruangan_id" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php foreach ($listRuangan as $r): ?>
                <option value="<?= $r['id'] ?>" <?= $selected_ruangan_id == $r['id'] ? "selected" : "" ?>>
                    <?= $r['nama'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Tanggal</label>
        <input type="date" name="tanggal" required value="<?= $_GET['tanggal'] ?? '' ?>">

        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" required value="<?= $_GET['jam_mulai'] ?? '' ?>">

        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" required value="<?= $_GET['jam_selesai'] ?? '' ?>">

        <label>Kegiatan</label>
        <textarea name="kegiatan" required></textarea>

        <label>Upload Surat Izin</label>
        <input type="file" name="surat_izin" required>

        <button class="btn-submit">Ajukan Booking</button>

    </form>

</div>

</body>
</html>
