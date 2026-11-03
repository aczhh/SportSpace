<?php

// =============================================
// COURT CONTROLLER
// Tanggung jawab: Anggota 2
// =============================================

class CourtController
{
    private ?PDO   $pdo;
    private ?Court $modelLapangan;

    public function __construct(?PDO $pdo)
    {
        $this->pdo           = $pdo;
        $this->modelLapangan = $pdo ? new Court($pdo) : null;
    }

    // GET /
    public function tampilHome(): void
    {
        if ($this->modelLapangan) {
            $courts      = $this->modelLapangan->getLatest(4);
            $sportCounts = $this->modelLapangan->countBySport();
        } else {
            // Pakai data dummy dari session (mode testing)
            $semuaCourt  = $_SESSION['dummy_courts'] ?? [];
            $courts      = array_slice($semuaCourt, 0, 4);
            $sportCounts = $this->hitungPerSport($semuaCourt);
        }

        require __DIR__ . '/../../views/customer/home.php';
    }

    // GET /courts
    // TODO: Anggota 2 – tampil daftar lapangan dengan filter
    public function tampilDaftarLapangan(): void
    {
        if ($this->modelLapangan) {
            $courts      = $this->modelLapangan->ambilSemua();
            $sportCounts = $this->modelLapangan->countBySport();
        } else {
            $courts      = $_SESSION['dummy_courts'] ?? [];
            $sportCounts = $this->hitungPerSport($courts);
        }

        // TODO: Anggota 2 kembangkan view ini
        require __DIR__ . '/../../views/customer/courts.php';
    }

    // GET /courts/detail?id=
    // TODO: Anggota 2 – tampil detail satu lapangan
    public function tampilDetailLapangan(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($this->modelLapangan) {
            $lapangan = $this->modelLapangan->ambilById($id);
        } else {
            $lapangan = $this->cariDummyById($id);
        }

        if (!$lapangan) {
            header('Location: /courts');
            exit;
        }

        // TODO: Anggota 2 kembangkan view ini
        require __DIR__ . '/../../views/customer/detail.php';
    }

    // -----------------------------------------
    // Helper: cari satu lapangan dari dummy session berdasarkan id
    // -----------------------------------------
    public static function cariDummyById(int $id): ?array
    {
        $semuaCourt = $_SESSION['dummy_courts'] ?? [];
        foreach ($semuaCourt as $court) {
            if ((int)$court['id'] === $id) return $court;
        }
        return null;
    }

    // -----------------------------------------
    // Helper: hitung jumlah lapangan per olahraga dari array
    // -----------------------------------------
    private function hitungPerSport(array $daftarCourt): array
    {
        $hasil = [];
        foreach ($daftarCourt as $court) {
            $jenis = $court['sport_type'];
            $hasil[$jenis] = ($hasil[$jenis] ?? 0) + 1;
        }
        return $hasil;
    }
}
