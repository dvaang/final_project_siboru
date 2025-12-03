<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function checkAuth() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");  // Kembali ke root
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function getUserInfo() {
    return [
        'id' => $_SESSION['user_id'] ?? null,
        'name' => $_SESSION['user_name'] ?? null,
        'email' => $_SESSION['user_email'] ?? null,
        'type' => $_SESSION['user_type'] ?? null
    ];
}
?>