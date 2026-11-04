<?php

// =============================================
// AUTH CONTROLLER – Tanggung jawab: Anggota 1
// =============================================

class AuthController
{
    private ?PDO  $pdo;
    private ?User $modelUser;

    public function __construct(?PDO $pdo)
    {
        $this->pdo       = $pdo;
        $this->modelUser = $pdo ? new User($pdo) : null;
    }

    public function tampilFormRegister(): void
    {
        require __DIR__ . '/../../views/auth/register.php';
    }

    public function tampilFormLogin(): void
    {
        require __DIR__ . '/../../views/auth/login.php';
    }

    // TODO: Anggota 1 – proses register
    public function prosesRegister(): void
    {
        header('Location: /login');
        exit;
    }

    // TODO: Anggota 1 – proses login
    public function prosesLogin(): void
    {
        header('Location: /');
        exit;
    }

    // TODO: Anggota 1 – proses logout
    public function prosesLogout(): void
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
