<?php
session_start();

if (isset($_SESSION['mahasiswa_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAKAD</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div style="text-align: center; margin-bottom: 20px;">
            <div style="font-size: 48px; margin-bottom: 15px;">🎓</div>
            <h1 style="color: #fff; font-size: 28px; margin: 0;">SIAKAD</h1>
            <p style="color: rgba(255,255,255,0.8); margin: 5px 0 0 0;">Sistem Informasi Akademik</p>
        </div>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%; margin-top: 20px;">Login</button>
        </form>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <div style="margin-top: 20px; text-align: center; color: rgba(255,255,255,0.7); font-size: 13px;">
            <p>Demo Login</p>
            <p>Username: <strong>rizal</strong> atau <strong>ihwan</strong></p>
            <p>Password: <strong>password123</strong></p>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>