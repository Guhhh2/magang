<?php
session_start();
include "../config/koneksi.php";

/* PROTEKSI LOGIN ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* QUERY DEFAULT */
$q = null;
$dari = $sampai = '';

if (isset($_GET['dari']) && isset($_GET['sampai'])) {

    $dari   = $_GET['dari'];
    $sampai = $_GET['sampai'];

    $q = mysqli_query($koneksi, "
        SELECT 
            k.nama,
            k.wilayah,
            k.jenis_kendaraan,
            m.tanggal,
            m.waktu
        FROM masuk_tps m
        JOIN kendaraan k ON m.kendaraan_id = k.id
        WHERE m.tanggal BETWEEN '$dari' AND '$sampai'
        ORDER BY m.tanggal ASC, m.waktu ASC
    ");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kendaraan TPS</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body class="dashboard">

<!-- HEADER HIJAU -->
<div class="header">
    <h2>📊 Laporan Kendaraan Masuk TPS</h2>
    <a href="dashboard.php" class="logout">⬅ Dashboard</a>
</div>

<!-- MENU -->
<div class="menu">
    <a href="dashboard.php" class="btn-scan">🏠 Dashboard</a>
</div>

<!-- CONTENT -->
<div class="content">

    <h3>Filter Laporan</h3>

    <!-- FORM FILTER -->
    <form method="GET" style="margin-bottom:20px; max-width:400px;">
        <label>Dari Tanggal</label>
        <input type="date" name="dari" required value="<?= $dari ?>">

        <label>Sampai Tanggal</label>
        <input type="date" name="sampai" required value="<?= $sampai ?>">

        <button type="submit" style="margin-top:10px">🔍 Tampilkan</button>
    </form>

    <?php if ($q) { ?>

        <!-- EXPORT -->
        <a 
            href="export_excel.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>" 
            class="btn-scan"
            style="background:#28a745; margin-bottom:15px; display:inline-block;"
        >
            📥 Export Excel
        </a>

        <!-- TABEL -->
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Wilayah</th>
                <th>Jenis Kendaraan</th>
                <th>Tanggal</th>
                <th>Waktu</th>
            </tr>

            <?php
            $no = 1;
            if (mysqli_num_rows($q) > 0) {
                while ($d = mysqli_fetch_assoc($q)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $d['nama'] ?></td>
                <td><?= $d['wilayah'] ?></td>
                <td><?= $d['jenis_kendaraan'] ?></td>
                <td><?= $d['tanggal'] ?></td>
                <td><?= $d['waktu'] ?></td>
            </tr>
            <?php 
                }
            } else {
            ?>
            <tr>
                <td colspan="6" class="empty">
                    Tidak ada data pada rentang tanggal ini
                </td>
            </tr>
            <?php } ?>
        </table>

    <?php } else { ?>

        <p style="color:#777">
            Silakan pilih rentang tanggal untuk menampilkan laporan.
        </p>

    <?php } ?>

</div>

</body>
</html>
