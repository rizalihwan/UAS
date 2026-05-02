<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: index.php?error=Username dan password harus diisi");
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT id, password, nama FROM mahasiswa WHERE username = ?");
        $stmt->execute([$username]);
        $mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mahasiswa && password_verify($password, $mahasiswa['password'])) {
            $_SESSION['mahasiswa_id'] = $mahasiswa['id'];
            $_SESSION['mahasiswa_nama'] = $mahasiswa['nama'];
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: index.php?error=Username atau password salah");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: index.php?error=Terjadi kesalahan sistem");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
