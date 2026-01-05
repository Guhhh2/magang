<?php
session_start();
include "../config/koneksi.php";

/* proteksi login */
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mandor') {
    header("Location: ../auth/login.php");
    exit;
}

/* ambil data hari ini */
$q = mysqli_query($koneksi, "
    SELECT k.nama, k.wilayah, k.jenis_kendaraan,
           m.waktu
    FROM masuk_tps m
    JOIN kendaraan k ON m.kendaraan_id = k.id
    WHERE m.tanggal = CURDATE()
    ORDER BY m.waktu DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Mandor</title>
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body class="dashboard">


<!-- HEADER -->
<div class="header">
    <h2>📋 Dashboard Mandor TPS</h2>
    <a href="../auth/logout.php" class="logout">Logout</a>
</div>

<!-- MENU -->
<div class="menu">
    <a href="scan.php" class="btn-scan">📷 Scan QR</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h3>Data Kendaraan Masuk (Hari Ini)</h3>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Wilayah</th>
            <th>Jenis</th>
            <th>Waktu Masuk</th>
        </tr>

        <?php
        $no=1;
        while($d = mysqli_fetch_assoc($q)){
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama'] ?></td>
            <td><?= $d['wilayah'] ?></td>
            <td><?= $d['jenis_kendaraan'] ?></td>
            <td><?= $d['waktu'] ?></td>
        </tr>
        <?php } ?>

        <?php if(mysqli_num_rows($q)==0){ ?>
        <tr>
            <td colspan="5" class="empty">Belum ada kendaraan masuk</td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>
