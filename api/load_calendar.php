<?php
require_once __DIR__ . '../config/database.php';
$db = (new Database())->getConnection();

$q = $db->prepare("
    SELECT b.id, b.tanggal, b.jam_mulai, b.jam_selesai, r.nama AS ruangan, b.status
    FROM bookings b
    JOIN ruangan r ON r.id = b.ruangan_id
    WHERE b.status IN ('diproses','disetujui')
");
$q->execute();
$res = $q->fetchAll(PDO::FETCH_ASSOC);

$out = [];
foreach ($res as $r) {
    $color = ($r['status'] === 'disetujui') ? '#4CAF50' : '#FF9800';
    $out[] = [
        'id' => $r['id'],
        'title' => $r['ruangan'] . ' (' . $r['jam_mulai'] . '-' . $r['jam_selesai'] . ')',
        'start' => $r['tanggal'] . 'T' . $r['jam_mulai'],
        'end' => $r['tanggal'] . 'T' . $r['jam_selesai'],
        'color' => $color
    ];
}
header('Content-Type: application/json');
echo json_encode($out);
