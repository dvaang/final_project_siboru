<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/database.php';
checkAuth();

// =======================
// Ambil data booking
// =======================
$id = $_GET['id'] ?? null;
$db = (new Database())->getConnection();

$stmt = $db->prepare("
    SELECT b.*, r.nama AS ruangan 
    FROM bookings b 
    JOIN ruangan r ON r.id=b.ruangan_id 
    WHERE b.id=? LIMIT 1
");
$stmt->execute([$id]);
$b = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$b) {
    echo "Booking tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Booking - SIBORU</title>
    <link rel="stylesheet" href="/coding/style.css">

    <style>
        /* Hilangkan tombol saat cetak */
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .bukti-container {
            max-width: 720px;
            margin: 40px auto;
            background: #ffffff;
            padding: 28px;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
        }

        .bukti-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .info-item {
            margin: 10px 0;
            font-size: 16px;
        }

        .info-label {
            font-weight: bold;
        }

        .btn-area {
            margin-top: 25px;
            text-align: center;
        }

        /* Tombol kembali */
        .btn-kembali {
            background: #666;
            color: white !important;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            margin-right: 10px;
            display: inline-block;
        }

        .btn-kembali:hover {
            background: #444;
        }
    </style>

</head>
<body>

<div class="bukti-container">
    
    <p class="bukti-title">BUKTI BOOKING RUANGAN - SIBORU</p>
    <hr><br>

    <p class="info-item"><span class="info-label">Ruangan:</span> <?= htmlspecialchars($b['ruangan']) ?></p>
    <p class="info-item"><span class="info-label">Pemesan:</span> <?= htmlspecialchars($b['nama_pemesan']) ?></p>
    <p class="info-item"><span class="info-label">Email:</span> <?= htmlspecialchars($b['email_pemesan']) ?></p>
    <p class="info-item"><span class="info-label">Tanggal:</span> <?= $b['tanggal'] ?></p>
    <p class="info-item"><span class="info-label">Jam:</span> <?= $b['jam_mulai'] ?> - <?= $b['jam_selesai'] ?></p>
    <p class="info-item"><span class="info-label">Status:</span> <?= ucfirst($b['status']) ?></p>
    <p class="info-item"><span class="info-label">Kegiatan:</span><br> <?= nl2br(htmlspecialchars($b['kegiatan'])) ?></p>

    <div class="btn-area no-print">
        <!-- TOMBOL KEMBALI -->
        <a class="btn-kembali" href="history.php">← Kembali</a>

        <!-- TOMBOL CETAK -->
        <button class="btn-submit" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

</div>

</body>
</html>
