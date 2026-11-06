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
    private ?PDO $pdo = null;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    // -----------------------------------------
    // Daftarkan route GET
    // -----------------------------------------
    public function get(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['GET', '/' . ltrim($path, '/'), $controller, $method];
    }

    // -----------------------------------------
    // Daftarkan route POST
    // -----------------------------------------
    public function post(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['POST', '/' . ltrim($path, '/'), $controller, $method];
    }

    // -----------------------------------------
    // Jalankan router: cari route yang cocok
    // lalu buat controller-nya dan panggil method-nya
    // -----------------------------------------
    public function jalankan(PDO $pdo): void
    {
        $this->pdo     = $pdo;
        $metodeBrowser = $_SERVER['REQUEST_METHOD'];
        $urlBrowser    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Bersihkan trailing slash (kecuali untuk root '/')
        if ($urlBrowser !== '/' && str_ends_with($urlBrowser, '/')) {
            $urlBrowser = rtrim($urlBrowser, '/');
        }

        foreach ($this->daftarRoute as [$metode, $path, $namaController, $namaMethod]) {
            if ($metode === $metodeBrowser && $path === $urlBrowser) {
                $controller = new $namaController($pdo);
                $controller->$namaMethod();
                return;
            }
        }

        // Tidak ada route yang cocok → tampilkan halaman 404
        http_response_code(404);
        echo '<h1>404 – Halaman tidak ditemukan</h1>';
    }
}
