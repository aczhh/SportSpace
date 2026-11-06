<?php

// =============================================
// FRONT CONTROLLER (pintu masuk aplikasi)
// Semua request masuk ke sini dulu
// sebelum diteruskan ke controller yang sesuai
// =============================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Load file konfigurasi & core ---
require_once __DIR__ . '/../src/Config/koneksi.php';
require_once __DIR__ . '/../src/Core/Router.php';

// --- Load semua Model ---
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Models/Court.php';
require_once __DIR__ . '/../src/Models/Booking.php';

// --- Load semua Controller ---
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/CourtController.php';
require_once __DIR__ . '/../src/Controllers/BookingController.php';
require_once __DIR__ . '/../src/Controllers/AdminController.php';

// --- Daftarkan semua route ---
$router = new Router($pdo);

// Halaman utama & lapangan (Anggota 2)
$router->get('/',              'CourtController', 'tampilHome');
$router->get('/courts',        'CourtController', 'tampilDaftarLapangan');
$router->get('/courts/detail', 'CourtController', 'tampilDetailLapangan');

// Autentikasi (Anggota 1)
$router->get('/register',    'AuthController', 'showRegister');
$router->get('/login',       'AuthController', 'showLogin');
$router->post('/register',   'AuthController', 'processRegister');
$router->post('/login',      'AuthController', 'processLogin');
$router->post('/logout',     'AuthController', 'logout');

// Login khusus admin
$router->get('/admin/login',  'AuthController', 'showAdminLogin');
$router->post('/admin/login', 'AuthController', 'processAdminLogin');

// Booking (Anggota 3)
$router->get('/booking',        'BookingController', 'tampilFormBooking');
$router->post('/booking/store', 'BookingController', 'simpanBooking');
$router->get('/my-bookings',    'BookingController', 'tampilRiwayatBooking');

// Admin (Anggota 3 + Anggota 2)
$router->get('/admin',          'AdminController', 'tampilDashboard');
$router->get('/admin/courts',   'AdminController', 'tampilKelolaLapangan');
$router->get('/admin/bookings', 'AdminController', 'tampilKelolaBooking');

$router->post('/admin/courts/store',           'AdminController', 'simpanLapangan');
$router->post('/admin/courts/update',          'AdminController', 'updateLapangan');
$router->post('/admin/courts/delete',          'AdminController', 'hapusLapangan');
$router->post('/admin/bookings/update-status', 'AdminController', 'updateStatusBooking');

// Profile
$router->get('/profile',  'AuthController', 'showProfile');
$router->post('/profile', 'AuthController', 'updateProfile');

// --- Jalankan router ---
$router->jalankan($pdo);
