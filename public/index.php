<?php

// =============================================
// FRONT CONTROLLER (pintu masuk aplikasi)
// Semua request masuk ke sini dulu
// sebelum diteruskan ke controller yang sesuai
// =============================================

session_start();

// --- Load file konfigurasi & core ---
require __DIR__ . '/../src/Config/koneksi.php';
require __DIR__ . '/../src/Core/Router.php';

// --- Load semua Model ---
require __DIR__ . '/../src/Models/User.php';
require __DIR__ . '/../src/Models/Court.php';
require __DIR__ . '/../src/Models/Booking.php';

// --- Load semua Controller ---
require __DIR__ . '/../src/Controllers/AuthController.php';
require __DIR__ . '/../src/Controllers/CourtController.php';
require __DIR__ . '/../src/Controllers/BookingController.php';
require __DIR__ . '/../src/Controllers/AdminController.php';

// --- Daftarkan semua route ---
$router = new Router();

// Halaman publik
$router->get('/',              'CourtController', 'tampilHome');
$router->get('/courts',        'CourtController', 'tampilDaftarLapangan');
$router->get('/courts/detail', 'CourtController', 'tampilDetailLapangan');

// Autentikasi (Anggota 1)
$router->get('/register',  'AuthController', 'tampilFormRegister');
$router->get('/login',     'AuthController', 'tampilFormLogin');
$router->post('/register', 'AuthController', 'prosesRegister');
$router->post('/login',    'AuthController', 'prosesLogin');
$router->post('/logout',   'AuthController', 'prosesLogout');

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

// --- Jalankan router ---
$router->jalankan($pdo);
