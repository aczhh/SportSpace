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

    // Daftarkan route GET
    public function get(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['GET', $path, $controller, $method];
    }

    // Daftarkan route POST
    public function post(string $path, string $controller, string $method): void
    {
        $this->daftarRoute[] = ['POST', $path, $controller, $method];
    }

    // Jalankan router: cari route yang cocok lalu panggil controller-nya
    public function jalankan(?PDO $pdo = null): void
    {
        $metodeBrowser = $_SERVER['REQUEST_METHOD'];
        $urlBrowser    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

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
}
