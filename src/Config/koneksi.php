<?php

// =============================================
// KONFIGURASI KONEKSI DATABASE
// Ubah host, nama_db, user, password
// sesuai pengaturan MySQL di komputer kalian
// =============================================

$host     = 'localhost';
$nama_db  = 'sportspace_db';
$user     = 'root';
$password = ''; // Sesuaikan dengan password Laragon/MySQL kamu
$charset  = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$nama_db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
    die('Koneksi database gagal: ' . $e->getMessage());
}
