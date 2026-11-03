<?php

class Court
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Lapangan terbaru untuk landing page
    public function getLatest(int $limit = 3): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM courts ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Jumlah lapangan per olahraga, hasilnya contoh: ['Futsal' => 4, 'Basket' => 2]
    public function countBySport(): array
    {
        $stmt = $this->pdo->query("SELECT sport_type, COUNT(*) FROM courts GROUP BY sport_type");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
}