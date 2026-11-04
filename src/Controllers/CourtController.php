<?php

// =============================================
// COURT CONTROLLER
// Tanggung jawab: Anggota 2
// Mengelola halaman home, daftar lapangan,
// detail lapangan, serta CRUD lapangan di admin
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

    // -----------------------------------------
    // TAMPIL HOME
    // GET /
    // -----------------------------------------
    public function tampilHome(): void
    {
        if ($this->modelLapangan) {
            $courts      = $this->modelLapangan->getLatest(4);
            $sportCounts = $this->modelLapangan->countBySport();
        } else {
            // Mode testing: pakai data dummy dari session
            $semuaCourt  = $_SESSION['dummy_courts'] ?? [];
            $courts      = array_slice($semuaCourt, 0, 4);
            $sportCounts = $this->hitungPerSport($semuaCourt);
        }

        require __DIR__ . '/../../views/customer/home.php';
    }

    // -----------------------------------------
    // TAMPIL DAFTAR LAPANGAN
    // GET /courts
    // Mendukung filter: ?sport=Futsal&q=Arena
    // -----------------------------------------
    public function tampilDaftarLapangan(): void
    {
        $filterSport = trim($_GET['sport'] ?? '');
        $filterNama  = trim($_GET['q']     ?? '');

        if ($this->modelLapangan) {
            $courts      = $this->modelLapangan->ambilDenganFilter($filterSport, $filterNama);
            $sportCounts = $this->modelLapangan->countBySport();
        } else {
            // Mode testing: filter dari session
            $semuaCourt  = $_SESSION['dummy_courts'] ?? [];
            $courts      = $this->filterDummy($semuaCourt, $filterSport, $filterNama);
            $sportCounts = $this->hitungPerSport($_SESSION['dummy_courts'] ?? []);
        }

        require __DIR__ . '/../../views/customer/courts.php';
    }

    // -----------------------------------------
    // TAMPIL DETAIL LAPANGAN
    // GET /courts/detail?id=
    // -----------------------------------------
    public function tampilDetailLapangan(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($this->modelLapangan) {
            $lapangan = $this->modelLapangan->ambilById($id);
        } else {
            $lapangan = self::cariDummyById($id);
        }

        if (!$lapangan) {
            header('Location: /courts');
            exit;
        }

        require __DIR__ . '/../../views/customer/detail.php';
    }

    // -----------------------------------------
    // HELPER: cari satu lapangan dummy berdasarkan id
    // Dipanggil juga oleh BookingController
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
    // HELPER: hitung jumlah lapangan per olahraga dari array
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

    // -----------------------------------------
    // HELPER: filter lapangan dari array dummy (mode testing)
    // -----------------------------------------
    private function filterDummy(array $daftarCourt, string $sport, string $nama): array
    {
        return array_values(array_filter($daftarCourt, function ($court) use ($sport, $nama) {
            $cocokSport = $sport === '' || $court['sport_type'] === $sport;
            $cocokNama  = $nama  === '' || stripos($court['name'], $nama) !== false;
            return $cocokSport && $cocokNama;
        }));
    }
}
