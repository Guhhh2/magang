<?php
include "../config/koneksi.php";

$kode = $_GET['kode'];

// cari kendaraan
$q = mysqli_query($koneksi, "SELECT * FROM kendaraan WHERE kode_barcode='$kode'");
$data = mysqli_fetch_assoc($q);

if ($data) {
    $id_kendaraan = $data['id'];

    mysqli_query($koneksi, "
        INSERT INTO masuk_tps (kendaraan_id, tanggal, waktu)
        VALUES ('$id_kendaraan', CURDATE(), CURTIME())
    ");

    echo "
    <div class='success'>
    <b>Data Tercatat</b><br>
    Nama: {$data['nama']} <br>
    Wilayah: {$data['wilayah']} <br>
    Jenis: {$data['jenis_kendaraan']} <br>
    Tarif: Rp {$data['tarif']} <br>
    Waktu: ".date('H:i:s')."
    </div>
    ";

    } else {
    echo "<div class='error'>QR tidak terdaftar!</div>";
}
