<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['mahasiswa_id'])) {
    header("Location: index.php");
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$message = '';
$messageType = '';

// Handle CRUD Operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $nama_matkul = trim($_POST['nama_matkul']);
        $semester = intval($_POST['semester']);
        $sks = intval($_POST['sks']);

        if (empty($nama_matkul) || $semester <= 0 || $sks <= 0) {
            $message = "Semua field harus diisi dengan benar!";
            $messageType = "error";
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO matakuliah (nama_matkul, semester, sks) VALUES (?, ?, ?)");
                $stmt->execute([$nama_matkul, $semester, $sks]);
                $message = "Matakuliah berhasil ditambahkan!";
                $messageType = "success";
                $action = 'list';
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = "error";
            }
        }
    } elseif ($action === 'edit') {
        $id_matkul = intval($_POST['id_matkul']);
        $nama_matkul = trim($_POST['nama_matkul']);
        $semester = intval($_POST['semester']);
        $sks = intval($_POST['sks']);

        if (empty($nama_matkul) || $semester <= 0 || $sks <= 0) {
            $message = "Semua field harus diisi dengan benar!";
            $messageType = "error";
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE matakuliah SET nama_matkul = ?, semester = ?, sks = ? WHERE id_matkul = ?");
                $stmt->execute([$nama_matkul, $semester, $sks, $id_matkul]);
                $message = "Matakuliah berhasil diperbarui!";
                $messageType = "success";
                $action = 'list';
            } catch (PDOException $e) {
                $message = "Error: " . $e->getMessage();
                $messageType = "error";
            }
        }
    }
} elseif ($action === 'delete' && isset($_GET['id'])) {
    $id_matkul = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("DELETE FROM matakuliah WHERE id_matkul = ?");
        $stmt->execute([$id_matkul]);
        $message = "Matakuliah berhasil dihapus!";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "error";
    }
    $action = 'list';
}

// Fetch data
$matakuliah_list = [];
if ($action === 'list') {
    try {
        $stmt = $pdo->query("SELECT * FROM matakuliah ORDER BY semester, id_matkul");
        $matakuliah_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "error";
    }
}

$matakuliah_edit = null;
if ($action === 'edit' && isset($_GET['id'])) {
    $id_matkul = intval($_GET['id']);
    try {
        $stmt = $pdo->prepare("SELECT * FROM matakuliah WHERE id_matkul = ?");
        $stmt->execute([$id_matkul]);
        $matakuliah_edit = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
        $messageType = "error";
        $action = 'list';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Matakuliah</title>
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
                <a href="mahasiswa.php" class="nav-link">Data Mahasiswa</a>
                <a href="matakuliah.php" class="nav-link active">Matakuliah</a>
                <a href="logout.php" class="nav-link logout">Logout</a>
            </div>
        </nav>

        <div class="content">
            <div class="page-header">
                <h1>Manajemen Matakuliah</h1>
                <p>Kelola data mata kuliah dan informasi akademik</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <?php if ($action === 'list'): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Daftar Matakuliah</h3>
                        <a href="matakuliah.php?action=add" class="btn btn-primary">+ Tambah Matakuliah</a>
                    </div>
                    <div class="card-body">
                        <?php if (count($matakuliah_list) > 0): ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Matakuliah</th>
                                        <th>Semester</th>
                                        <th>SKS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($matakuliah_list as $index => $matkul): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo htmlspecialchars($matkul['nama_matkul']); ?></td>
                                            <td><?php echo $matkul['semester']; ?></td>
                                            <td><?php echo $matkul['sks']; ?></td>
                                            <td class="action-cell">
                                                <a href="matakuliah.php?action=edit&id=<?php echo $matkul['id_matkul']; ?>" class="btn btn-sm btn-edit">Edit</a>
                                                <a href="matakuliah.php?action=delete&id=<?php echo $matkul['id_matkul']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="no-data">Tidak ada data matakuliah.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ($action === 'add'): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Tambah Matakuliah Baru</h3>
                    </div>
                    <div class="card-body">
                        <form action="matakuliah.php?action=add" method="POST" class="form">
                            <div class="form-group">
                                <label for="nama_matkul">Nama Matakuliah:</label>
                                <input type="text" id="nama_matkul" name="nama_matkul" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="semester">Semester:</label>
                                    <input type="number" id="semester" name="semester" min="1" max="8" required>
                                </div>
                                <div class="form-group">
                                    <label for="sks">SKS:</label>
                                    <input type="number" id="sks" name="sks" min="1" max="4" required>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="matakuliah.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>

            <?php elseif ($action === 'edit' && $matakuliah_edit): ?>
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Matakuliah</h3>
                    </div>
                    <div class="card-body">
                        <form action="matakuliah.php?action=edit" method="POST" class="form">
                            <input type="hidden" name="id_matkul" value="<?php echo $matakuliah_edit['id_matkul']; ?>">
                            <div class="form-group">
                                <label for="nama_matkul">Nama Matakuliah:</label>
                                <input type="text" id="nama_matkul" name="nama_matkul" value="<?php echo htmlspecialchars($matakuliah_edit['nama_matkul']); ?>" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="semester">Semester:</label>
                                    <input type="number" id="semester" name="semester" value="<?php echo $matakuliah_edit['semester']; ?>" min="1" max="8" required>
                                </div>
                                <div class="form-group">
                                    <label for="sks">SKS:</label>
                                    <input type="number" id="sks" name="sks" value="<?php echo $matakuliah_edit['sks']; ?>" min="1" max="4" required>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a href="matakuliah.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="main.js"></script>
</body>

</html>
