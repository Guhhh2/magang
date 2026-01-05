<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Aplikasi TPS</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

<div class="login-box">

    <img src="../assets/img/dlh.png" class="logo">
    <h2>Login Aplikasi TPS</h2>

    <?php if(isset($_GET['error'])){ ?>
        <div class="error">Username atau Password salah</div>
    <?php } ?>

    <form method="POST" action="proses_login.php">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

</div>

</body>
</html>
