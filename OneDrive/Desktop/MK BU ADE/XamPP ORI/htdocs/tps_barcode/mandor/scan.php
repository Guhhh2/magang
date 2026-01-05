<?php
session_start();
include "../config/koneksi.php";

/* proteksi login */
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'mandor') {
    header("Location: ../auth/login.php");
    exit;
}

error_reporting(0);
ini_set('display_errors', 0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Scan QR Masuk TPS</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body class="dashboard">

<div class="content" style="max-width:400px;margin:40px auto;text-align:center">
    <h2>📷 Scan QR Kendaraan</h2>

    <div id="reader" style="width:300px;margin:20px auto;"></div>
    <div id="hasil"></div>

    <a href="dashboard.php" class="btn-scan" style="display:inline-block;margin-top:15px">
        ⬅ Kembali
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    function onScanSuccess(decodedText) {
        fetch("proses_scan.php?kode=" + decodedText)
            .then(res => res.text())
            .then(data => {
                document.getElementById("hasil").innerHTML = data;
            });

        html5QrcodeScanner.stop(); // stop setelah scan
    }

    const html5QrcodeScanner = new Html5Qrcode("reader");

    html5QrcodeScanner.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        onScanSuccess
    ).catch(err => {
        document.getElementById("hasil").innerHTML =
            "<div class='error'>Kamera tidak bisa diakses</div>";
        console.error(err);
    });

});
</script>

</body>
</html>
