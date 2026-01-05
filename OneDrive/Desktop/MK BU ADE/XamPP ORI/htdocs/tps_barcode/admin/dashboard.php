<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin TPS</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body class="dashboard">

<div class="topbar">
    <h2>Dashboard Admin TPS</h2>

    <div class="menu-btn">
        <a href="dashboard.php" class="btn-dashboard">Dashboard</a>
        <a href="laporan.php" class="btn-laporan">Laporan</a>
        <a href="tarif.php" class="btn-tarif">Tarif</a>
        <a href="create_barcode.php" class="btn-barcode">Barcode</a>
        <a href="../auth/logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="content">
    <h3>Menu Utama</h3>

    <div class="card-grid">

        <div class="card">
            <h3>Create Barcode</h3>
            <p>Buat QR kendaraan TPS</p>
            <a href="create_barcode.php">Buka</a>
        </div>

        <div class="card">
            <h3>Laporan Kendaraan</h3>
            <p>Data kendaraan masuk TPS</p>
            <a href="laporan.php">Buka</a>
        </div>

        <div class="card">
            <h3>Tarif Harga</h3>
            <p>Kelola tarif kendaraan</p>
            <a href="tarif.php">Buka</a>
        </div>

    </div>
</div>

</body>
</html>
