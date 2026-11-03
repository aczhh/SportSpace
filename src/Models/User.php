<?php

// =============================================
// MODEL USER
// Tanggung jawab: Anggota 1
// Mengelola query ke tabel users
// =============================================

class User
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // TODO: Anggota 1 – cari user berdasarkan email (untuk login)
    public function cariByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    // TODO: Anggota 1 – simpan user baru ke database (untuk register)
    public function buat(array $data): bool
    {
        $sql  = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'customer')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name'     => $data['name'],
            ':email'    => $data['email'],
            ':password' => $data['password'], // sudah di-hash sebelum dikirim ke sini
        ]);
    }
}

