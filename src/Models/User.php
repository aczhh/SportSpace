<?php

// =============================================
// MODEL USER
// Tanggung jawab: Anggota 1
// Mengelola semua query ke tabel users
// =============================================

class User
{
    private PDO $pdo;

    // Menerima koneksi database dari Controller
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // -----------------------------------------
    // Membuat akun customer baru
    // Role selalu 'customer' — admin dibuat via seed database
    // -----------------------------------------
    public function create(string $name, string $email, string $password): bool
    {
        $sql = "INSERT INTO users (name, email, password, role)
                VALUES (:name, :email, :password, 'customer')";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $password,
        ]);
    }

    // -----------------------------------------
    // Mencari pengguna berdasarkan email
    // Digunakan saat login dan cek duplikat email
    // -----------------------------------------
    public function findByEmail(string $email): array|false
    {
        $sql  = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // -----------------------------------------
    // Mencari pengguna berdasarkan ID
    // Tidak menyertakan kolom password
    // -----------------------------------------
    public function findById(int $id): array|false
    {
        $sql = "SELECT id, name, email, role, created_at
                FROM users
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // -----------------------------------------
    // Update nama pengguna berdasarkan ID
    // -----------------------------------------
    public function updateName(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id = :id");
        return $stmt->execute([':name' => $name, ':id' => $id]);
    }
}
