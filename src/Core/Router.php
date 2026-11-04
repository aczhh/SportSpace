<?php

// =============================================
// ROUTER
// Menerima request dari browser dan meneruskan
// ke controller yang sesuai berdasarkan route
// =============================================

class Router
{
    // Daftar semua route yang terdaftar
    // Format: ['METHOD', '/path', NamaController, 'namaMethod']
    private array $daftarRoute = [];
    protected ?PDO $pdo = null;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    // Daftarkan route GET
    public function get(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['GET', '/' . ltrim($path, '/'), $controller, $method];
    }

    // Daftarkan route POST
    public function post(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['POST', '/' . ltrim($path, '/'), $controller, $method];
    }

    // Kompatibilitas dengan method add() dari Anggota 1
    public function add(string $method, string $route, string $controller, string $action): void
    {
        $method = strtoupper($method);
        $path   = '/' . ltrim($route, '/');
        $this->daftarRoute[] = [$method, $path, $controller, $action];
    }

    // Jalankan router: cari route yang cocok lalu panggil controller-nya
    public function jalankan(PDO $pdo): void
    {
        $this->pdo = $pdo;
        $metodeBrowser = $_SERVER['REQUEST_METHOD'];
        $urlBrowser    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Bersihkan trailing slash (kecuali untuk root '/')
        if ($urlBrowser !== '/' && str_ends_with($urlBrowser, '/')) {
            $urlBrowser = rtrim($urlBrowser, '/');
        }

        foreach ($this->daftarRoute as [$metode, $path, $namaController, $namaMethod]) {
            if ($metode === $metodeBrowser && $path === $urlBrowser) {
                // Buat objek controller dan panggil method-nya
                $controller = new $namaController($pdo);
                $controller->$namaMethod();
                return;
            }
        }

        // Tidak ada route yang cocok → tampilkan halaman 404
        http_response_code(404);
        echo '<h1>404 – Halaman tidak ditemukan</h1>';
    }

    // Kompatibilitas method dispatch() dari Anggota 1
    public function dispatch(?string $url = null, ?string $method = null)
    {
        $metode = $method ? strtoupper($method) : $_SERVER['REQUEST_METHOD'];
        $url    = '/' . ltrim(parse_url($url ?? $_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($url !== '/' && str_ends_with($url, '/')) {
            $url = rtrim($url, '/');
        }

        foreach ($this->daftarRoute as [$m, $p, $namaController, $namaMethod]) {
            if ($m === $metode && $p === $url) {
                $controller = new $namaController($this->pdo);
                return $controller->$namaMethod();
            }
        }

        http_response_code(404);
        echo '<h1>404 – Halaman tidak ditemukan</h1>';
    }
}

// Daftarkan alias agar bisa diakses lewat namespace App\Core\Router juga
if (!class_exists('App\Core\Router', false)) {
    class_alias(Router::class, 'App\Core\Router');
}
