<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../config/database.php';
include_once '../config/session.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get all rooms
    if (!isset($_GET['action'])) {
        $query = "SELECT * FROM ruangan ORDER BY nama";
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $ruangan = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ruangan[] = $row;
        }
        
        echo json_encode([
            "success" => true,
            "data" => $ruangan
        ]);
    }
    
    // Check room availability
    if ($_GET['action'] == 'check_availability') {
        $ruangan_id = $_GET['ruangan_id'];
        $tanggal = $_GET['tanggal'];
        $jam_mulai = $_GET['jam_mulai'];
        $jam_selesai = $_GET['jam_selesai'];
        
        $query = "SELECT * FROM bookings 
                 WHERE ruangan_id = :ruangan_id 
                 AND tanggal = :tanggal 
                 AND status IN ('diproses', 'disetujui')
                 AND ((jam_mulai < :jam_selesai AND jam_selesai > :jam_mulai))";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(":ruangan_id", $ruangan_id);
        $stmt->bindParam(":tanggal", $tanggal);
        $stmt->bindParam(":jam_mulai", $jam_mulai);
        $stmt->bindParam(":jam_selesai", $jam_selesai);
        $stmt->execute();
        
        $isAvailable = $stmt->rowCount() == 0;
        
        echo json_encode([
            "success" => true,
            "available" => $isAvailable
        ]);
    }
}
?>