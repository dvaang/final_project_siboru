<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/session.php';

$db = (new Database())->getConnection();
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Validasi input
    if (empty($email) || empty($pass)) {
        $error = "Email dan password harus diisi!";
    } else {
        $q = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $q->execute([$email]);
        $u = $q->fetch(PDO::FETCH_ASSOC);

        // PERINGATAN: Di production gunakan password_verify()
        if ($u && $u['password'] == $pass) {
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['user_name'] = $u['name'];
            $_SESSION['user_email'] = $u['email'];
            $_SESSION['user_type'] = $u['type'];

            // Redirect berdasarkan user type
            if ($u['type'] == "admin") {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            $error = "Email atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login SIBORU</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<div class="dashboard" style="max-width:380px;">
    <div class="card">
        <h2>Login SIBORU</h2>
        
        <?php if(!empty($error)): ?>
            <p style="color:red; padding:10px; background:#fee; border-radius:5px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>
        
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required 
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            
            <label>Password</label>
            <input type="password" name="password" required>  <!-- Ganti ke type="password" -->
            
            <button class="btn-submit" type="submit">Login</button>
        </form>
    </div>
</div>
</body>
</html>