<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} // Memulai session

//Menghubungkan ke database
require_once __DIR__ . '/../src/Config/koneksi.php';

//Autoload class dari folder src
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return; } // Memastikan class menggunakan namespace App
    $classPath = substr($class, strlen($prefix)); // Mengubah namespace menjadi lokasi file

    $file = __DIR__ . '/../src/' .
        str_replace('\\', '/', $classPath) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new \App\Core\Router($pdo); // 4. Membuat objek Router dengan koneksi database PDO

// 5. Mendaftarkan route Authentication
// Halaman Login
$router->add(
    'GET',
    'login',
    \App\Controllers\AuthController::class,
    'showLogin'
);

// Proses Login
$router->add(
    'POST',
    'login',
    \App\Controllers\AuthController::class,
    'processLogin'
);

// Halaman Register
$router->add(
    'GET',
    'register',
    \App\Controllers\AuthController::class,
    'showRegister'
);

// Proses Register
$router->add(
    'POST',
    'register',
    \App\Controllers\AuthController::class,
    'processRegister'
);

// Logout
$router->add(
    'POST',
    'logout',
    \App\Controllers\AuthController::class,
    'logout'
);

// 6. Mengambil URL dan HTTP Method
$url = $_GET['url'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// 7. Menjalankan Router
$router->dispatch($url, $method);

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
