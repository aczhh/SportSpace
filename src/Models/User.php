<?php

namespace App\Models;
use PDO;
class User
{
    private $pdo;
    // Menerima koneksi database dari Controller
    public function __construct(PDO $pdo)
    { $this->pdo = $pdo; }

    // Membuat akun customer baru
    public function create($name, $email, $password)
    {   $sql = "INSERT INTO users (name, email, password, role)
                VALUES (:name, :email, :password, 'customer')";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':name'     => $name,
            ':email'    => $email,
            ':password' => $password
        ]);
    }

    // Mencari pengguna berdasarkan email
    public function findByEmail($email)
    {   $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email ]);
           return $stmt->fetch();
    }

    // Mencari pengguna berdasarkan ID
    public function findById($id)
    {   $sql = "SELECT id, name, email, role, created_at
                FROM users
                WHERE id = :id
                LIMIT 1";
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id ]);
        return $stmt->fetch();
    }
}
