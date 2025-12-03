<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT c.*, r.nama as ruangan_nama 
             FROM contacts c 
             JOIN ruangan r ON c.ruangan_id = r.id 
             ORDER BY r.nama";
    
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    $contacts = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $contacts[] = $row;
    }
    
    echo json_encode([
        "success" => true,
        "data" => $contacts
    ]);
}
?>