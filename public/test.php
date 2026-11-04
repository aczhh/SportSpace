<?php

// ============================================================
// FILE TEST / DEV - JANGAN DIPAKAI DI PRODUCTION
// ============================================================
// Cara pakai:
//   1. Buka terminal di folder SportSpace
//   2. Jalankan: php -S localhost:8000 public/test.php
//   3. Buka browser: http://localhost:8000/
//
// Tidak perlu MySQL, tidak perlu XAMPP, tidak perlu login.
// Semua data disimpan di session PHP.
//
// URL khusus untuk testing:
//   /test-reset    → hapus semua booking, mulai dari awal
//   /test-admin    → ganti jadi akun admin
//   /test-customer → ganti balik jadi akun customer
// ============================================================

// Kalau file statis diminta (CSS, JS, gambar), biarkan PHP serve sendiri
if (php_sapi_name() === 'cli-server') {
    $fileDiminta = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($fileDiminta)) {
        return false;
    }
}

session_start();

// ============================================================
// DATA LAPANGAN DUMMY (disimpan sebagai konstanta)
// ============================================================
$dummyCourts = [
    [
        'id'            => 1,
        'name'          => 'Arena Garuda Futsal',
        'sport_type'    => 'Futsal',
        'description'   => 'Lapangan futsal indoor standar nasional dengan lantai vinyl anti-slip.',
        'facilities'    => 'Toilet, kantin, parkir luas, ruang ganti',
        'price_per_hour'=> 150000,
        'image'         => 'court.jpg',
        'created_at'    => date('Y-m-d H:i:s'),
    ],
    [
        'id'            => 2,
        'name'          => 'GOR Smash Badminton',
        'sport_type'    => 'Badminton',
        'description'   => 'GOR badminton ber-AC dengan 6 lapangan tersedia.',
        'facilities'    => 'AC, tribun, musala, parkir',
        'price_per_hour'=> 60000,
        'image'         => 'court.jpg',
        'created_at'    => date('Y-m-d H:i:s'),
    ],
    [
        'id'            => 3,
        'name'          => 'Hoops Court Basket',
        'sport_type'    => 'Basket',
        'description'   => 'Lapangan basket outdoor dengan lampu sorot untuk malam hari.',
        'facilities'    => 'Lampu sorot, tribun, toilet, parkir',
        'price_per_hour'=> 100000,
        'image'         => 'court.jpg',
        'created_at'    => date('Y-m-d H:i:s'),
    ],
    [
        'id'            => 4,
        'name'          => 'Futsal Pro Arena',
        'sport_type'    => 'Futsal',
        'description'   => 'Lapangan futsal premium dengan fasilitas VIP dan scoring board.',
        'facilities'    => 'AC, tribun VIP, kantin, toilet, scoring board',
        'price_per_hour'=> 175000,
        'image'         => 'court.jpg',
        'created_at'    => date('Y-m-d H:i:s'),
    ],
];

// Simpan courts ke session agar bisa diakses controller
$_SESSION['dummy_courts'] = $dummyCourts;

// ============================================================
// URL KHUSUS UNTUK KONTROL TESTING
// ============================================================
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Hapus semua booking → mulai dari awal
if ($url === '/test-reset') {
    $_SESSION['dummy_bookings'] = [];
    header('Location: /my-bookings');
    exit;
}

// Ganti ke akun admin
if ($url === '/test-admin') {
    $_SESSION['user_id'] = 2;
    $_SESSION['role']    = 'admin';
    $_SESSION['name']    = 'Admin SportSpace';
    header('Location: /admin');
    exit;
}

// Ganti balik ke akun customer
if ($url === '/test-customer') {
    $_SESSION['user_id'] = 1;
    $_SESSION['role']    = 'customer';
    $_SESSION['name']    = 'Budi Santoso';
    header('Location: /');
    exit;
}

// ============================================================
// AUTO-LOGIN: Masuk otomatis sebagai customer
// ============================================================
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1;
    $_SESSION['role']    = 'customer';
    $_SESSION['name']    = 'Budi Santoso';
}

// Inisialisasi list booking di session kalau belum ada
if (!isset($_SESSION['dummy_bookings'])) {
    $_SESSION['dummy_bookings'] = [];
}

// ============================================================
// LOAD FILE MVC
// ============================================================
require __DIR__ . '/../src/Core/Router.php';
require __DIR__ . '/../src/Models/User.php';
require __DIR__ . '/../src/Models/Court.php';
require __DIR__ . '/../src/Models/Booking.php';
require __DIR__ . '/../src/Controllers/AuthController.php';
require __DIR__ . '/../src/Controllers/CourtController.php';
require __DIR__ . '/../src/Controllers/BookingController.php';
require __DIR__ . '/../src/Controllers/AdminController.php';

// Gunakan PDO dummy (null) — controller akan pakai data session
$pdo = null;

// ============================================================
// REGISTER SEMUA ROUTE
// ============================================================
$router = new Router();

$router->get('/',              'CourtController',   'tampilHome');
$router->get('/courts',        'CourtController',   'tampilDaftarLapangan');
$router->get('/courts/detail', 'CourtController',   'tampilDetailLapangan');

$router->get('/register',  'AuthController', 'tampilFormRegister');
$router->get('/login',     'AuthController', 'tampilFormLogin');
$router->post('/register', 'AuthController', 'prosesRegister');
$router->post('/login',    'AuthController', 'prosesLogin');
$router->post('/logout',   'AuthController', 'prosesLogout');

$router->get('/booking',        'BookingController', 'tampilFormBooking');
$router->post('/booking/store', 'BookingController', 'simpanBooking');
$router->get('/my-bookings',    'BookingController', 'tampilRiwayatBooking');

$router->get('/admin',          'AdminController', 'tampilDashboard');
$router->get('/admin/courts',   'AdminController', 'tampilKelolaLapangan');
$router->get('/admin/bookings', 'AdminController', 'tampilKelolaBooking');

$router->post('/admin/courts/store',           'AdminController', 'simpanLapangan');
$router->post('/admin/courts/update',          'AdminController', 'updateLapangan');
$router->post('/admin/courts/delete',          'AdminController', 'hapusLapangan');
$router->post('/admin/bookings/update-status', 'AdminController', 'updateStatusBooking');

$router->jalankan($pdo);
