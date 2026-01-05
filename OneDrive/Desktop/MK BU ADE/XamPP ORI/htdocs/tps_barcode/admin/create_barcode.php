<?php
error_reporting(E_ALL);

set_error_handler(function ($errno, $errstr) {
    // MATIKAN SEMUA DEPRECATED
    if ($errno === E_DEPRECATED || $errno === E_NOTICE) {
        return true; // STOP DI SINI
    }
    return false;
});

ob_start();

include "../config/koneksi.php";
include "../assets/phpqrcode/qrlib.php";

$sukses = false;
$kode = "";

if (isset($_POST['simpan'])) {

    $nama    = $_POST['nama'];
    $wilayah = $_POST['wilayah'];
    $jenis   = $_POST['jenis'];

    $kode  = "TPS-" . rand(1000,9999);
    $tarif = ($jenis == "Grobak") ? 5000 : 10000;

    mysqli_query($koneksi, "
        INSERT INTO kendaraan (nama, wilayah, jenis_kendaraan, kode_barcode, tarif)
        VALUES ('$nama','$wilayah','$jenis','$kode','$tarif')
    ");

    if (!is_dir("../barcode")) {
        mkdir("../barcode", 0777, true);
    }

    QRcode::png($kode, "../barcode/$kode.png", QR_ECLEVEL_L, 6);

    $sukses = true;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Barcode TPS</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="login-box">

    <img src="../assets/img/dlh.png" class="logo">
    <h2>Buat Barcode TPS</h2>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Wilayah</label>
        <input type="text" name="wilayah" required>

        <label>Jenis Kendaraan</label>
        <select name="jenis" required>
            <option value="Grobak">Grobak</option>
            <option value="Tossa">Tossa</option>
        </select>

        <button name="simpan">Buat Barcode</button>
    </form>

    <?php if ($sukses): ?>
        <div class="success">Barcode Berhasil Dibuat</div>
        <div class="qr">
            <img src="../barcode/<?= $kode ?>.png" width="180"><br>
            <a href="../barcode/<?= $kode ?>.png" download>Download Barcode</a>
        </div>
    <?php endif; ?>
    
</div>

</body>
</html>

<?php
ob_end_flush();
