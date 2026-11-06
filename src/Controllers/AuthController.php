<?php

// =============================================
// AUTH CONTROLLER
// Tanggung jawab: Anggota 1
// Mengelola registrasi, login, logout,
// dan pembatasan akses berdasarkan role
// =============================================

class AuthController
{
    private User $user;
    private string $baseUrl;

    public function __construct(PDO $pdo)
    {
        $this->user = new User($pdo);
        // Menentukan base URL agar redirect bisa berjalan di sub-folder
        $this->baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    }

    // -----------------------------------------
    // HELPER: redirect ke path tertentu
    // -----------------------------------------
    private function redirect(string $path): void
    {
        header('Location: ' . $this->baseUrl . '/' . ltrim($path, '/'));
        exit;
    }

    // -----------------------------------------
    // GET /login
    // Tampilkan halaman login customer
    // -----------------------------------------
    public function showLogin(): void
    {
        // Jika sudah login, langsung arahkan ke halaman yang sesuai
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] === 'admin') {
                $this->redirect('admin');
            }
            $this->redirect('');
        }

        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../../views/auth/login.php';
    }

    // -----------------------------------------
    // POST /login
    // Proses login customer
    // -----------------------------------------
    public function processLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        $email    = trim($_POST['email']    ?? '');
        $password =      $_POST['password'] ?? '';

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

        // Simpan data pengguna ke session
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        // Arahkan berdasarkan role
        if ($user['role'] === 'admin') {
            $this->redirect('admin');
        }
        $this->redirect('');
    }

    // -----------------------------------------
    // GET /admin/login
    // Tampilkan halaman login khusus admin
    // -----------------------------------------
    public function showAdminLogin(): void
    {
        // Jika sudah login sebagai admin, langsung ke dashboard
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $this->redirect('admin');
        }
        // Jika sudah login sebagai customer, arahkan ke home
        if (isset($_SESSION['user'])) {
            $this->redirect('');
        }

        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../../views/auth/login-admin.php';
    }

    // -----------------------------------------
    // POST /admin/login
    // Proses login admin
    // -----------------------------------------
    public function processAdminLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/login');
        }

        $email    = trim($_POST['email']    ?? '');
        $password =      $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $_SESSION['error'] = 'Email dan password wajib diisi.';
            $this->redirect('admin/login');
        }

        $user = $this->user->findByEmail($email);

        // Hanya izinkan user dengan role admin
        if (!$user || $user['role'] !== 'admin' || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Email/password salah, atau akun bukan admin.';
            $this->redirect('admin/login');
        }

        // Mencegah session fixation
        session_regenerate_id(true);

        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];

        $this->redirect('admin');
    }

    // -----------------------------------------
    // GET /register
    // Tampilkan halaman register
    // -----------------------------------------
    public function showRegister(): void
    {
        if (isset($_SESSION['user'])) {
            $this->redirect('');
        }

        $baseUrl = $this->baseUrl;
        require __DIR__ . '/../../views/auth/register.php';
    }

    // -----------------------------------------
    // POST /register
    // Proses registrasi customer baru
    // -----------------------------------------
    public function processRegister(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('register');
        }

        $name            = trim($_POST['name']             ?? '');
        $email           = trim($_POST['email']            ?? '');
        $password        =      $_POST['password']         ?? '';
        $confirmPassword =      $_POST['confirm_password'] ?? '';

        // Validasi: semua kolom wajib diisi
        if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
            $_SESSION['error'] = 'Semua kolom wajib diisi.';
            $this->redirect('register');
        }

        if (strlen($name) > 100) {
            $_SESSION['error'] = 'Nama maksimal 100 karakter.';
            $this->redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
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

        // Periksa email duplikat
        if ($this->user->findByEmail($email)) {
            $_SESSION['error'] = 'Email sudah terdaftar.';
            $this->redirect('register');
        }

        // Hash password sebelum disimpan ke database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Simpan customer baru ke database
        $this->user->create($name, $email, $hashedPassword);

        $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
        $this->redirect('login');
    }

    // -----------------------------------------
    // GET /profile
    // Halaman profil user
    // -----------------------------------------
    public function showProfile(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
        }

        $baseUrl  = $this->baseUrl;
        $userData = $_SESSION['user'];
        $success  = $_SESSION['success'] ?? null;
        $error    = $_SESSION['error']   ?? null;
        unset($_SESSION['success'], $_SESSION['error']);

        require __DIR__ . '/../../views/auth/profile.php';
    }

    // -----------------------------------------
    // POST /profile
    // Update nama profil user
    // -----------------------------------------
    public function updateProfile(): void
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
        }

        $name = trim($_POST['name'] ?? '');
        if ($name === '' || strlen($name) > 100) {
            $_SESSION['error'] = 'Nama tidak valid (maks 100 karakter).';
            $this->redirect('profile');
        }

        $this->user->updateName((int) $_SESSION['user']['id'], $name);
        $_SESSION['user']['name'] = $name;
        $_SESSION['success'] = 'Profil berhasil diperbarui.';
        $this->redirect('profile');
    }

    // -----------------------------------------
    // POST /logout
    // Logout dan hancurkan session
    // -----------------------------------------
    public function logout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Method tidak diizinkan.');
        }

        $_SESSION = [];
        session_regenerate_id(true);
        session_destroy();
        $this->redirect('login');
    }
}
