<?php

// =============================================
// MODEL COURT (LAPANGAN)
// Tanggung jawab: Anggota 2 (diperluas)
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
    // Ambil semua lapangan dengan filter opsional
    // $filterSport : '' = semua, 'Futsal' = hanya futsal
    // $filterNama  : '' = semua, 'arena' = pencarian nama
    // -----------------------------------------
    public function ambilDenganFilter(string $filterSport = '', string $filterNama = ''): array
    {
        $kondisi = [];
        $params  = [];

        if ($filterSport !== '') {
            $kondisi[] = 'sport_type = :sport';
            $params[':sport'] = $filterSport;
        }

        if ($filterNama !== '') {
            $kondisi[] = 'name LIKE :nama';
            $params[':nama'] = '%' . $filterNama . '%';
        }

        $klausa = $kondisi ? 'WHERE ' . implode(' AND ', $kondisi) : '';

        $sql  = "SELECT * FROM courts {$klausa} ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    // -----------------------------------------
    // Ambil semua lapangan tanpa filter (untuk admin)
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

    // -----------------------------------------
    // Tambah lapangan baru
    // $data harus berisi: name, sport_type, description,
    //                     facilities, price_per_hour, image
    // -----------------------------------------
    public function buat(array $data): bool
    {
        $sql = "INSERT INTO courts (name, sport_type, description, facilities, price_per_hour, image)
                VALUES (:name, :sport_type, :description, :facilities, :price_per_hour, :image)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name'          => $data['name'],
            ':sport_type'    => $data['sport_type'],
            ':description'   => $data['description'],
            ':facilities'    => $data['facilities'],
            ':price_per_hour'=> $data['price_per_hour'],
            ':image'         => $data['image'],
        ]);
    }

    // -----------------------------------------
    // Update data lapangan berdasarkan ID
    // -----------------------------------------
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE courts
                SET name = :name, sport_type = :sport_type, description = :description,
                    facilities = :facilities, price_per_hour = :price_per_hour, image = :image
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':name'          => $data['name'],
            ':sport_type'    => $data['sport_type'],
            ':description'   => $data['description'],
            ':facilities'    => $data['facilities'],
            ':price_per_hour'=> $data['price_per_hour'],
            ':image'         => $data['image'],
            ':id'            => $id,
        ]);
    }

    // -----------------------------------------
    // Hapus lapangan berdasarkan ID
    // -----------------------------------------
    public function hapus(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM courts WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
