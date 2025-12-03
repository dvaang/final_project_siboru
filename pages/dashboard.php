<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();
$uid = $_SESSION['user_id'];

// HITUNG TOTAL NOTIF AKTIF
$notifCount = $db->prepare("SELECT COUNT(*) FROM bookings WHERE user_id=? AND notif_panitia=1");
$notifCount->execute([$uid]);
$jumlah_notif = $notifCount->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard Panitia</title>
<link rel="stylesheet" href="../style.css">
<style>
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.notif-btn {
    position: relative;
    font-size: 24px;
    text-decoration: none;
}
.notif-badge {
    position: absolute;
    top: -6px;
    right: -10px;
    background: #e74c3c;
    color: #fff;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 14px;
    display: inline-block;
}
.logout-btn {
    text-decoration: none;
    background: #c0392b;
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
}
.card {
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 6px;
    box-shadow: 1px 1px 5px rgba(0,0,0,0.05);
}
.btn, .btn-submit {
    text-decoration: none;
    background: #3498db;
    color: #fff;
    padding: 6px 12px;
    border-radius: 4px;
    display: inline-block;
}
</style>
</head>
<body>

<div class="dashboard">

    <!-- Header Dashboard -->
    <div class="dashboard-header">
        <h2>Halo, <?= $_SESSION['user_name'] ?> (Panitia)</h2>
        <div>
            <!-- Tombol Notifikasi -->
            <a href="notifikasi.php" class="notif-btn" title="Notifikasi Panitia">
                🔔
                <?php if ($jumlah_notif > 0): ?>
                    <span class="notif-badge"><?= $jumlah_notif ?></span>
                <?php endif; ?>
            </a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <!-- Kartu Dashboard -->
    <div class="card">
        <h3>Ketersediaan Ruangan</h3>
        <a class="btn" href="calendar.php">Lihat Kalender</a>
    </div>

    <div class="card">
        <h3>Booking Ruangan</h3>
        <a class="btn-submit" href="panitia.php">Mulai Booking</a>
    </div>

    <div class="card">
        <h3>Riwayat Booking</h3>
        <a class="btn-submit" href="history.php">Lihat Riwayat</a>
    </div>

    <div class="card">
        <h3>Kontak Pengelola Ruangan</h3>
        <a class="btn-submit" href="contacts.php">Lihat Kontak</a>
    </div>

</div>

</body>
</html>
