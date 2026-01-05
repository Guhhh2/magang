<?php
session_start();
include "../config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$q = mysqli_query($koneksi, "SELECT * FROM tarif");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tarif Kendaraan</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body class="dashboard">

<div class="topbar">
    <h2>Tarif Kendaraan TPS</h2>
    <div class="menu-btn">
        <a href="dashboard.php" class="btn-dashboard">Dashboard</a>
    </div>
</div>

<div class="content">
<table>
<tr>
    <th>No</th>
    <th>Jenis Kendaraan</th>
    <th>Tarif</th>
</tr>

<?php $no=1; while($d=mysqli_fetch_assoc($q)){ ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['jenis_kendaraan'] ?></td>
    <td>Rp <?= number_format($d['tarif']) ?></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
