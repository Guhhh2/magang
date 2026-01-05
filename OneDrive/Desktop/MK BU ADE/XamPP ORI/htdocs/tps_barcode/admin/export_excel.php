<?php
session_start();
include "../config/koneksi.php";

/* PROTEKSI LOGIN ADMIN */
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* VALIDASI PARAMETER */
if (!isset($_GET['dari']) || !isset($_GET['sampai'])) {
    die("Parameter tanggal tidak valid");
}

$dari   = $_GET['dari'];
$sampai = $_GET['sampai'];

/* HEADER EXCEL */
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_tps_{$dari}_sd_{$sampai}.xls");

/* QUERY */
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
?>

<table border="1">
    <tr style="background:#ddd; font-weight:bold">
        <th>No</th>
        <th>Nama</th>
        <th>Wilayah</th>
        <th>Jenis Kendaraan</th>
        <th>Tanggal</th>
        <th>Waktu Masuk</th>
    </tr>

<?php
$no = 1;
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
<?php } ?>

</table>
