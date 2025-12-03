<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: pages/login.php");
    exit;
}

// Redirect ke dashboard jika sudah login
if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
   header("Location: pages/admin.php");
} else {
    header("Location: pages/dashboard.php");
}
exit;
?>