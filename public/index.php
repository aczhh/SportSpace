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
