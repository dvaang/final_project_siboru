<?php
include_once '../config/session.php';
include_once '../config/database.php';

header("Content-Type: application/json");

$database = new Database();
$db = $database->getConnection();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->rowCount() === 1) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($password, $user['password'])) {
        echo json_encode(['success' => true, 'message' => 'Login berhasil']);
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Email atau password salah']);
exit;
