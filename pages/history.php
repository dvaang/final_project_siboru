<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();

// Ambil riwayat booking + rating jika ada
$stmt = $db->prepare("
    SELECT b.*, r.nama AS ruangan, rt.rating, rt.komentar
    FROM bookings b
    JOIN ruangan r ON r.id = b.ruangan_id
    LEFT JOIN ratings rt 
        ON rt.ruangan_id = b.ruangan_id AND rt.user_id = b.user_id
    WHERE b.user_id = ?
    ORDER BY b.created_at DESC
");
$stmt->execute([$_SESSION['user_id']]);
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Booking</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .dashboard h2 { margin-bottom: 20px; }
        .btn { text-decoration: none; background: #3498db; color: #fff; padding: 6px 12px; border-radius: 4px; margin-bottom: 15px; display: inline-block; }
        .card { border: 1px solid #ddd; border-left: 5px solid #3498db; padding: 15px; margin-bottom: 15px; border-radius: 6px; box-shadow: 1px 1px 5px rgba(0,0,0,0.05); }
        .card p { margin: 6px 0; }
        .status { font-weight: bold; padding: 3px 8px; border-radius: 4px; color: #fff; font-size: 14px; }
        .status.diproses { background: #f39c12; }
        .status.disetujui { background: #27ae60; }
        .status.ditolak { background: #c0392b; }
        .btn-submit { text-decoration: none; background: #2ecc71; color: #fff; padding: 6px 12px; border-radius: 4px; display: inline-block; margin-top: 10px; }

        /* Flex container untuk tombol dan rating */
        .action-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }
        .rating {
            font-weight: bold;
            color: #f39c12;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <h2>Riwayat Booking</h2>
    <a href="dashboard.php" class="btn">← Kembali ke Dashboard</a>

    <?php if(empty($list)): ?>
        <p>Belum ada riwayat booking.</p>
    <?php endif; ?>

    <?php foreach ($list as $b): ?>
        <div class="card">
            <p><strong>Ruangan:</strong> <?= htmlspecialchars($b['ruangan']) ?></p>
            <p><strong>Tanggal & Waktu:</strong> <?= $b['tanggal'] ?> | <?= $b['jam_mulai'] ?> - <?= $b['jam_selesai'] ?></p>
            <p><strong>Kegiatan:</strong> <?= htmlspecialchars($b['kegiatan']) ?></p>
            <p><strong>Status:</strong> <span class="status <?= $b['status'] ?>"><?= ucfirst($b['status']) ?></span></p>

            <!-- Baris aksi: tombol + rating -->
            <div class="action-row">
                <?php if($b['status'] !== 'diproses'): ?>
                    <a class="btn-submit" href="bukti_booking.php?id=<?= $b['id'] ?>">Cetak Bukti</a>
                <?php endif; ?>

                <?php if(isset($b['rating']) && $b['rating'] > 0): ?>
                    <span class="rating">Rating: <?= htmlspecialchars($b['rating']) ?> ⭐</span>
                <?php elseif($b['status'] === 'disetujui'): ?>
                    <a class="btn-submit" href="rating.php?id=<?= $b['id'] ?>">Beri Rating</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
