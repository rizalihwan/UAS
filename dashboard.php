<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['mahasiswa_id'])) {
    header("Location: index.php");
    exit();
}

$mahasiswa_id = $_SESSION['mahasiswa_id'];

try {
    $stmt = $pdo->prepare("SELECT nama, nim, email FROM mahasiswa WHERE id = ?");
    $stmt->execute([$mahasiswa_id]);
    $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$mahasiswa) {
        session_destroy();
        header("Location: index.php?error=Data mahasiswa tidak ditemukan");
        exit();
    }
} catch (PDOException $e) {
    session_destroy();
    header("Location: index.php?error=Terjadi kesalahan sistem");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">
                <h2>SIAKAD</h2>
            </div>
            <div class="navbar-menu">
                <a href="dashboard.php" class="nav-link active">Dashboard</a>
                <a href="mahasiswa.php" class="nav-link">Data Mahasiswa</a>
                <a href="matakuliah.php" class="nav-link">Matakuliah</a>
                <a href="logout.php" class="nav-link logout">Logout</a>
            </div>
        </nav>

        <div class="content">
            <div class="page-header">
                <h1>Selamat datang, <?php echo htmlspecialchars($mahasiswa['nama']); ?>!</h1>
                <p>Sistem Informasi Akademik</p>
            </div>

            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-icon">👤</div>
                    <h3>Profil Mahasiswa</h3>
                    <div class="info-item">
                        <span class="label">Nama:</span>
                        <span class="value"><?php echo htmlspecialchars($mahasiswa['nama']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">NIM:</span>
                        <span class="value"><?php echo htmlspecialchars($mahasiswa['nim']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo htmlspecialchars($mahasiswa['email']); ?></span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon">📚</div>
                    <h3>Akses Data Akademik</h3>
                    <div class="card-actions">
                        <a href="mahasiswa.php" class="btn btn-info">Lihat Data Mahasiswa</a>
                        <a href="matakuliah.php" class="btn btn-info">Kelola Matakuliah</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon">⚙️</div>
                    <h3>Akun Saya</h3>
                    <div class="card-actions">
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>