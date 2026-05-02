<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['mahasiswa_id'])) {
    header("Location: index.php");
    exit();
}

$mahasiswa_list = [];
try {
    $stmt = $pdo->query("SELECT id, username, nama, nim, email FROM mahasiswa ORDER BY nama");
    $mahasiswa_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Get current user info
try {
    $stmt = $pdo->prepare("SELECT nama FROM mahasiswa WHERE id = ?");
    $stmt->execute([$_SESSION['mahasiswa_id']]);
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $current_user = [];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="main-container">
        <nav class="navbar">
            <div class="navbar-brand">
                <h2>SIAKAD</h2>
            </div>
            <div class="navbar-menu">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
                <a href="mahasiswa.php" class="nav-link active">Data Mahasiswa</a>
                <a href="matakuliah.php" class="nav-link">Matakuliah</a>
                <a href="logout.php" class="nav-link logout">Logout</a>
            </div>
        </nav>

        <div class="content">
            <div class="page-header">
                <h1>Data Mahasiswa</h1>
                <p>Daftar semua mahasiswa yang terdaftar di sistem</p>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Daftar Mahasiswa</h3>
                    <span class="badge"><?php echo count($mahasiswa_list); ?> mahasiswa</span>
                </div>
                <div class="card-body">
                    <?php if (count($mahasiswa_list) > 0): ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mahasiswa_list as $index => $mahasiswa): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($mahasiswa['nama']); ?></strong>
                                            <?php if ($mahasiswa['id'] === $_SESSION['mahasiswa_id']): ?>
                                                <span class="badge-primary">(Anda)</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($mahasiswa['nim']); ?></td>
                                        <td><code><?php echo htmlspecialchars($mahasiswa['username']); ?></code></td>
                                        <td><?php echo htmlspecialchars($mahasiswa['email']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="no-data">Tidak ada data mahasiswa.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>
