<?php
require_once "../config/session.php";
require_once "../config/database.php";
checkAuth();

$db = (new Database())->getConnection();
$q = $db->prepare("SELECT * FROM ruangan ORDER BY nama ASC");
$q->execute();
$ruangan = $q->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html><head><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="dashboard">
<h2>Form Pilih Ruangan</h2>

<div class="card">
<form method="GET" action="booking.php">

<label>Pilih Ruangan</label>
<select name="ruangan_id" required>
<option value="">-- Pilih Ruangan --</option>
<?php foreach($ruangan as $r): ?>
<option value="<?= $r['id'] ?>"><?= $r['nama'] ?></option>
<?php endforeach; ?>
</select>

<label>Tanggal</label>
<input type="date" name="tanggal" required>

<label>Jam Mulai</label>
<input type="time" name="jam_mulai" required>

<label>Jam Selesai</label>
<input type="time" name="jam_selesai" required>

<button class="btn-submit">Lanjutkan</button>

</form>
</div>
</div>
</body>
</html>
