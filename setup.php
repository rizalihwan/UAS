<?php
$host = 'localhost';
$dbname = 'php_tugas';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE IF NOT EXISTS mahasiswa (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        nama VARCHAR(100) NOT NULL,
        nim VARCHAR(20) UNIQUE NOT NULL,
        email VARCHAR(100)
    )";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS matakuliah (
        id_matkul INT AUTO_INCREMENT PRIMARY KEY,
        nama_matkul VARCHAR(100) NOT NULL,
        semester INT NOT NULL,
        sks INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sql);

    $stmt = $pdo->query("SELECT COUNT(*) FROM mahasiswa");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO mahasiswa (username, password, nama, nim, email) VALUES
            ('rizal', '$hashedPassword', 'Rizal Ihwan', '12345678', 'rizal@email.com'),
            ('ihwan', '$hashedPassword', 'Ihwan Sulaiman', '87654321', 'ihwan@email.com')";
        $pdo->exec($sql);
    }

    $stmt = $pdo->query("SELECT COUNT(*) FROM matakuliah");
    $countMatkul = $stmt->fetchColumn();

    if ($countMatkul == 0) {
        $sql = "INSERT INTO matakuliah (nama_matkul, semester, sks) VALUES
            ('Pemrograman Web', 1, 3),
            ('Basis Data', 2, 4),
            ('Algoritma dan Struktur Data', 1, 4),
            ('Jaringan Komputer', 3, 3),
            ('Mobile Programming', 4, 3),
            ('Keamanan Siber', 3, 2)";
        $pdo->exec($sql);
    }

    echo "Database, tabel, dan data dummy berhasil dibuat!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
