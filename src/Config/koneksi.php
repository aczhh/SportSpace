<?php

// =============================================
// KONFIGURASI KONEKSI DATABASE
// Ubah host, nama_db, user, password
// sesuai pengaturan MySQL di komputer kalian
// =============================================

$host      = 'localhost';
$nama_db   = 'sportspace_db';
$user      = 'root';
$password  = '';

// Buat koneksi PDO ke MySQL
try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$nama_db};charset=utf8mb4",
        $user,
        $password
    );

    // Tampilkan error sebagai exception agar mudah di-debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Hasil fetch berupa array asosiatif (key = nama kolom)
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Hentikan aplikasi dan tampilkan pesan error
    die('Koneksi database gagal: ' . $e->getMessage());
}

