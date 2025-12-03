<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../config/database.php';
include_once '../config/session.php';

checkAuth();

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user = getUserInfo();
    
    // Get user's bookings
    if ($_GET['action'] == 'user_bookings') {
        $query = "SELECT b.*, r.nama as ruangan_nama 
                 FROM bookings b 
                 JOIN ruangan r ON b.ruangan_id = r.id 
                 WHERE b.user_id = :user_id 
                 ORDER BY b.created_at DESC";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(":user_id", $user['id']);
        $stmt->execute();
        
        $bookings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bookings[] = $row;
        }
        
        echo json_encode([
            "success" => true,
            "data" => $bookings
        ]);
    }
    
    // Get all bookings (admin only)
    if ($_GET['action'] == 'all_bookings' && isAdmin()) {
        $query = "SELECT b.*, r.nama as ruangan_nama, u.name as user_name 
                 FROM bookings b 
                 JOIN ruangan r ON b.ruangan_id = r.id 
                 JOIN users u ON b.user_id = u.id 
                 ORDER BY b.created_at DESC";
        
        $stmt = $db->prepare($query);
        $stmt->execute();
        
        $bookings = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $bookings[] = $row;
        }
        
        echo json_encode([
            "success" => true,
            "data" => $bookings
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $user = getUserInfo();
    
    // Create new booking
    $query = "INSERT INTO bookings 
              (ruangan_id, user_id, nama_pemesan, email_pemesan, tanggal, jam_mulai, jam_selesai, kegiatan, surat_izin) 
              VALUES 
              (:ruangan_id, :user_id, :nama_pemesan, :email_pemesan, :tanggal, :jam_mulai, :jam_selesai, :kegiatan, :surat_izin)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":ruangan_id", $data->ruangan_id);
    $stmt->bindParam(":user_id", $user['id']);
    $stmt->bindParam(":nama_pemesan", $user['name']);
    $stmt->bindParam(":email_pemesan", $user['email']);
    $stmt->bindParam(":tanggal", $data->tanggal);
    $stmt->bindParam(":jam_mulai", $data->jam_mulai);
    $stmt->bindParam(":jam_selesai", $data->jam_selesai);
    $stmt->bindParam(":kegiatan", $data->kegiatan);
    $stmt->bindParam(":surat_izin", $data->surat_izin);
    
    if ($stmt->execute()) {
        // Update room status
        $updateQuery = "UPDATE ruangan SET status = 'terbooking' WHERE id = :ruangan_id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(":ruangan_id", $data->ruangan_id);
        $updateStmt->execute();
        
        echo json_encode([
            "success" => true,
            "message" => "Booking berhasil dibuat",
            "booking_id" => $db->lastInsertId()
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Gagal membuat booking"
        ]);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Update booking status (admin only)
    if (!isAdmin()) {
        echo json_encode([
            "success" => false,
            "message" => "Akses ditolak"
        ]);
        exit;
    }
    
    $data = json_decode(file_get_contents("php://input"));
    
    $query = "UPDATE bookings SET status = :status, alasan_penolakan = :alasan, processed_by = :admin_id, processed_at = NOW() WHERE id = :booking_id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":status", $data->status);
    $stmt->bindParam(":alasan", $data->alasan_penolakan);
    $stmt->bindParam(":admin_id", $_SESSION['user_id']);
    $stmt->bindParam(":booking_id", $data->booking_id);
    
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Status booking berhasil diupdate"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Gagal mengupdate status booking"
        ]);
    }
}
?>