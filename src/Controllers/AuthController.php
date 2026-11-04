<?php

namespace App\Controllers;
use App\Models\User;
use PDO;

class AuthController
{   private $user;
    private $baseUrl;
    public function __construct(PDO $pdo)
    {   $this->user = new User($pdo);
        // Menentukan lokasi folder public secara otomatis
        $this->baseUrl = rtrim(
            dirname($_SERVER['SCRIPT_NAME']),
            '/\\'
        );
    }

    // Mengarahkan pengguna ke halaman tertentu
    private function redirect($path)
    {   header(
            'Location: ' . $this->baseUrl . '/' . ltrim($path, '/')    );
        exit;
    }

    // Menampilkan halaman login
    public function showLogin()
    {   if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                $this->redirect('admin');
            }

            $this->redirect('');
        }
        $baseUrl = dirname($_SERVER['SCRIPT_NAME']);
        require __DIR__ . '/../../views/auth/login.php';
    }

    // Memproses login
    public function processLogin()
    {   if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login'); }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Email dan password wajib diisi.';
            $this->redirect('login');
        }

        $user = $this->user->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Email atau password salah.';
            $this->redirect('login');
        }

        // Mencegah session fixation
        session_regenerate_id(true);

        // Menyimpan informasi pengguna ke session
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role']
        ];

        // Mengarahkan berdasarkan role
        if ($user['role'] === 'admin') {
            $this->redirect('admin');
        }
        $this->redirect('');
    }

    // Menampilkan halaman register
    public function showRegister()
    {   if (isset($_SESSION['user'])) {
            $this->redirect('');  }
        require __DIR__ . '/../../views/auth/register.php';
    }

    // Memproses registrasi customer
    public function processRegister()
    {   if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('register');    }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validasi input
        if ($name === '' || $email === '' ||
            $password === '' || $confirmPassword === '') {

            $_SESSION['error'] = 'Semua kolom wajib diisi.';
            $this->redirect('register');
        }

        if (strlen($name) > 100) {
            $_SESSION['error'] = 'Nama maksimal 100 karakter.';
            $this->redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) ||
            strlen($email) > 100) {

            $_SESSION['error'] = 'Format email tidak valid.';
            $this->redirect('register');
        }

        if (strlen($password) < 8) {
            $_SESSION['error'] = 'Password minimal 8 karakter.';
            $this->redirect('register');
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Konfirmasi password tidak cocok.';
            $this->redirect('register');
        }

        // Memeriksa email yang sudah terdaftar
        if ($this->user->findByEmail($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar.';
            $this->redirect('register');
        }

        // Mengamankan password sebelum disimpan
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        // Menyimpan customer baru
        $this->user->create(
            $name,
            $email,
            $hashedPassword
        );

        $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
        $this->redirect('login');
    }

    // Logout pengguna
    public function logout()
    {   if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method tidak diizinkan.');
        }

        $_SESSION = [];
        session_regenerate_id(true);
        session_destroy();
        $this->redirect('login');
    }
}
