<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$id = $_GET['id'] ?? null;
$db = (new Database())->getConnection();

$error = "";
$success = "";

if ($_POST) {
    $rating = $_POST['rating'];
    $komentar = $_POST['komentar'];

    $q = $db->prepare("INSERT INTO ratings (ruangan_id, user_id, rating, komentar, created_at) 
                       VALUES (?, ?, ?, ?, NOW())");
    $q->execute([$id, $_SESSION['user_id'], $rating, $komentar]);

    $success = "Rating berhasil dikirim!";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../style.css">
<title>Rating Ruangan</title>
</head>
<body>

<div class="dashboard">

<h2>Rating Ruangan</h2>
<a class="btn" href="history.php">Kembali</a>

<?php if ($success): ?>
<p class="success"><?= $success ?></p>
<?php endif; ?>

<form method="POST">
    <label>Rating (1–5)</label>
    <input type="number" name="rating" min="1" max="5" required>

    <label>Komentar</label>
    <textarea name="komentar" required></textarea>

    <button class="btn-submit">Kirim</button>
</form>

</div>
</body>
</html>
