<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();
$uid = $_SESSION['user_id'];

// Ambil semua notifikasi aktif
$q = $db->prepare("
    SELECT * FROM bookings 
    WHERE user_id=? AND notif_panitia=1 
    ORDER BY processed_at DESC
");
$q->execute([$uid]);
$list = $q->fetchAll(PDO::FETCH_ASSOC);

// Setelah dibuka → anggap sudah dibaca
$db->prepare("UPDATE bookings SET notif_panitia=0 WHERE user_id=?")
   ->execute([$uid]);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Notifikasi Booking</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="dashboard">

    <h2>Notifikasi Booking</h2>
    <a class="btn" href="dashboard.php">Kembali</a>

    <div class="card">
        <?php if (count($list) === 0): ?>
            <p>Tidak ada notifikasi baru.</p>
        <?php endif; ?>

        <?php foreach ($list as $n): ?>
            <div class="card" style="margin-bottom:10px;">
                <p><strong>Status:</strong> 
                    <span class="status <?= $n['status'] ?>"><?= ucfirst($n['status']) ?></span>
                </p>

                <?php if ($n['status'] === 'ditolak'): ?>
                    <p><strong>Alasan Penolakan:</strong><br>
                        <?= nl2br(htmlspecialchars($n['alasan_penolakan'])) ?>
                    </p>
                <?php endif; ?>

                <p><strong>Tanggal:</strong> <?= $n['tanggal'] ?></p>
                <p><strong>Jam:</strong> <?= $n['jam_mulai'] ?> - <?= $n['jam_selesai'] ?></p>

                <a class="btn-submit" href="bukti_booking.php?id=<?= $n['id'] ?>">Lihat Bukti Booking</a>
            </div>
        <?php endforeach; ?>
    </div>

</div>
</body>
</html>
