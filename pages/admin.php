<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();
if (!isAdmin()) { header("Location: dashboard.php"); exit; }

$db = (new Database())->getConnection();

// =======================
// APPROVE BOOKING (GET)
// =======================
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];

    // Dapatkan ruangan
    $q = $db->prepare("SELECT ruangan_id FROM bookings WHERE id = ? LIMIT 1");
    $q->execute([$id]);
    $row = $q->fetch(PDO::FETCH_ASSOC);

    if ($row) {

        // Set booking disetujui + notif panitia
        $u = $db->prepare("
            UPDATE bookings 
            SET status='disetujui',
                processed_by=?,
                processed_at=NOW(),
                notif_panitia = 1
            WHERE id=?
        ");
        $u->execute([$_SESSION['user_id'], $id]);

        // Set ruangan terbooking
        $db->prepare("UPDATE ruangan SET status='terbooking' WHERE id=?")
           ->execute([$row['ruangan_id']]);
    }

    header("Location: admin.php");
    exit;
}

// =======================
// TOLAK BOOKING (POST)
// =======================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_id'])) {
    $id = (int)$_POST['reject_id'];
    $alasan = trim($_POST['alasan_penolakan'] ?? '');

    $u = $db->prepare("
        UPDATE bookings 
        SET status='ditolak',
            alasan_penolakan=?,
            processed_by=?,
            processed_at=NOW(),
            notif_panitia = 1
        WHERE id=?
    ");
    $u->execute([$alasan, $_SESSION['user_id'], $id]);

    // Ubah ruangan menjadi kosong
    $db->prepare("
        UPDATE ruangan 
        SET status='kosong' 
        WHERE id = (SELECT ruangan_id FROM bookings WHERE id = ?)
    ")->execute([$id]);

    header("Location: admin.php");
    exit;
}

// =======================
// FETCH SEMUA BOOKING
// =======================
$q = $db->prepare("
    SELECT b.*, r.nama AS ruangan, u.name AS pemesan_name, u.email AS pemesan_email
    FROM bookings b
    JOIN ruangan r ON r.id = b.ruangan_id
    JOIN users u ON u.id = b.user_id
    ORDER BY b.created_at DESC
");
$q->execute();
$list = $q->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="dashboard">

    <h2>Halo, <?= htmlspecialchars($_SESSION['user_name']) ?> (Admin)</h2>
    <a href="logout.php" class="logout-btn">Logout</a>

    <div class="card">
        <h3>Daftar Semua Booking</h3>

        <?php if (count($list) === 0): ?>
            <p>Belum ada booking masuk.</p>
        <?php endif; ?>

        <?php foreach ($list as $b): ?>
            <div class="card" style="margin-bottom:10px;">

                <p><strong>Ruangan:</strong> <?= htmlspecialchars($b['ruangan']) ?></p>
                <p><strong>Pemesan:</strong> <?= htmlspecialchars($b['pemesan_name']) ?> (<?= htmlspecialchars($b['pemesan_email']) ?>)</p>

                <p>
                    <strong>Tanggal:</strong> <?= $b['tanggal'] ?><br>
                    <strong>Jam:</strong> <?= $b['jam_mulai'] ?> - <?= $b['jam_selesai'] ?>
                </p>

                <p><strong>Kegiatan:</strong> <?= nl2br(htmlspecialchars($b['kegiatan'])) ?></p>

                <p><strong>Status:</strong> 
                    <span class="status <?= $b['status'] ?>">
                        <?= ucfirst($b['status']) ?>
                    </span>
                </p>

                <?php if ($b['surat_izin']): ?>
                    <p><a class="btn" href="../upload/<?= htmlspecialchars($b['surat_izin']) ?>" target="_blank">Lihat Surat Izin</a></p>
                <?php endif; ?>

                <!-- ACTION BUTTON -->
                <?php if ($b['status'] === 'diproses'): ?>

                    <a class="btn-submit" 
                       href="admin.php?approve=<?= $b['id'] ?>" 
                       onclick="return confirm('Setujui booking ini?')">
                        Setujui
                    </a>

                    <button class="btn-cancel" 
                            onclick="document.getElementById('rej<?= $b['id'] ?>').style.display='block'">
                        Tolak
                    </button>

                    <div id="rej<?= $b['id'] ?>" style="display:none;margin-top:8px;">
                        <form method="POST">
                            <input type="hidden" name="reject_id" value="<?= $b['id'] ?>">
                            <label>Alasan Penolakan</label>
                            <textarea name="alasan_penolakan" required></textarea>
                            <button class="btn-cancel" type="submit">Kirim Penolakan</button>
                        </form>
                    </div>

                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    </div>
</div>

</body>
</html>
