<?php

// =============================================
// MODEL COURT (LAPANGAN)
// Mengelola semua query ke tabel courts
// =============================================

class Court
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // -----------------------------------------
    // Ambil beberapa lapangan terbaru
    // Dipakai di landing page home.php
    // -----------------------------------------
    public function getLatest(int $batas = 4): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courts ORDER BY created_at DESC LIMIT :batas");
        $stmt->bindValue(':batas', $batas, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // -----------------------------------------
    // Hitung jumlah lapangan per jenis olahraga
    // Hasil contoh: ['Futsal' => 4, 'Badminton' => 6]
    // -----------------------------------------
    public function countBySport(): array
    {
        $stmt = $this->pdo->query("SELECT sport_type, COUNT(*) FROM courts GROUP BY sport_type");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    // -----------------------------------------
    // Ambil satu lapangan berdasarkan ID
    // Dipakai di form booking & detail lapangan
    // -----------------------------------------
    public function ambilById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courts WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $lapangan = $stmt->fetch();
        return $lapangan ?: null;
    }

    // -----------------------------------------
    // Ambil semua lapangan (untuk admin & daftar)
    // TODO: Anggota 2 bisa tambah filter olahraga & nama
    // -----------------------------------------
    public function ambilSemua(): array
    {
        return $this->pdo->query("SELECT * FROM courts ORDER BY created_at DESC")->fetchAll();
    }

    // -----------------------------------------
    // Hitung total lapangan (untuk dashboard admin)
    // -----------------------------------------
    public function hitungTotal(): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM courts")->fetchColumn();
    }

    // TODO: Anggota 2 – tambah lapangan baru
    public function buat(array $data): bool
    {
        $sql = "INSERT INTO courts (name, sport_type, description, facilities, price_per_hour, image)
                VALUES (:name, :sport_type, :description, :facilities, :price_per_hour, :image)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    // TODO: Anggota 2 – update data lapangan
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE courts
                SET name = :name, sport_type = :sport_type, description = :description,
                    facilities = :facilities, price_per_hour = :price_per_hour, image = :image
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data[':id'] = $id;
        return $stmt->execute($data);
    }

    // TODO: Anggota 2 – hapus lapangan
    public function hapus(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM courts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
