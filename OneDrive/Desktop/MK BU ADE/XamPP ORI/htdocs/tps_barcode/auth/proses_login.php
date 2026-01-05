<?php
session_start();
include "../config/koneksi.php";

$u = $_POST['username'] ?? '';
$p = md5($_POST['password'] ?? '');

$q = mysqli_query($koneksi,
    "SELECT * FROM users WHERE username='$u' AND password='$p'"
);

$data = mysqli_fetch_assoc($q);

if ($data) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../mandor/dashboard.php");
    }
    exit;
} else {
    header("Location: login.php?error=1");
    exit;
}
