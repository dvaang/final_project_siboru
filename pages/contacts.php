<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();

$sql = $db->prepare("SELECT c.*, r.nama AS ruangan 
                     FROM contacts c 
                     JOIN ruangan r ON r.id=c.ruangan_id
                     ORDER BY r.nama");
$sql->execute();
$list = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../style.css">
<title>Kontak Pengelola</title>
</head>
<body>

<div class="dashboard">
<h2>Kontak Pengelola Ruangan</h2>
<a href="dashboard.php" class="btn">Kembali</a>

<?php foreach($list as $c): ?>
<div class="card">
    <p><strong>Ruangan:</strong> <?= $c['ruangan'] ?></p>
    <p><strong>Nama Pengelola:</strong> <?= $c['nama_pengelola'] ?></p>
    <p><strong>Telepon:</strong> <?= $c['telepon'] ?></p>
    <p><strong>Email:</strong> <?= $c['email'] ?></p>
    <p><strong>Jam Kerja:</strong> <?= $c['jam_kerja'] ?></p>
</div>
<?php endforeach; ?>

</div>
</body>
</html>
