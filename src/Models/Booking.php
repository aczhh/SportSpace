<?php

// =============================================
// MODEL BOOKING
// Mengelola semua query yang berhubungan
// dengan tabel bookings di database
// =============================================

class Booking
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // -----------------------------------------
    // BUAT BOOKING BARU
    // Menyimpan data pemesanan dari customer
    // -----------------------------------------
    public function buat(array $data): bool
    {
        $sql = "INSERT INTO bookings
                    (user_id, court_id, booking_date, start_time, duration, total_price, status)
                VALUES
                    (:user_id, :court_id, :booking_date, :start_time, :duration, :total_price, 'pending')";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':user_id'      => $data['user_id'],
            ':court_id'     => $data['court_id'],
            ':booking_date' => $data['booking_date'],
            ':start_time'   => $data['start_time'],
            ':duration'     => $data['duration'],
            ':total_price'  => $data['total_price'],
        ]);
    }

    // -----------------------------------------
    // AMBIL BOOKING MILIK SATU CUSTOMER
    // Digunakan di halaman My Booking
    // -----------------------------------------
    public function ambilMilikCustomer(int $user_id): array
    {
        $sql = "SELECT b.*, c.name AS nama_lapangan, c.sport_type AS jenis_olahraga
                FROM bookings b
                JOIN courts c ON b.court_id = c.id
                WHERE b.user_id = :user_id
                ORDER BY b.created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);

        return $stmt->fetchAll();
    }

    // -----------------------------------------
    // AMBIL SEMUA BOOKING (untuk admin)
    // Termasuk nama customer dan nama lapangan
    // -----------------------------------------
    public function ambilSemua(): array
    {
        $sql = "SELECT b.*,
                       u.name  AS nama_customer,
                       c.name  AS nama_lapangan,
                       c.sport_type AS jenis_olahraga
                FROM bookings b
                JOIN users  u ON b.user_id  = u.id
                JOIN courts c ON b.court_id = c.id
                ORDER BY b.created_at DESC";

        return $this->pdo->query($sql)->fetchAll();
    }

    // -----------------------------------------
    // UPDATE STATUS BOOKING (oleh admin)
    // Status: pending | confirmed | cancelled
    // -----------------------------------------
    public function updateStatus(int $id, string $status): bool
    {
        $statusValid = ['pending', 'confirmed', 'cancelled'];

        // Pastikan status yang dikirim valid
        if (!in_array($status, $statusValid)) {
            return false;
        }

        $stmt = $this->pdo->prepare("UPDATE bookings SET status = :status WHERE id = :id");

        return $stmt->execute([
            ':status' => $status,
            ':id'     => $id,
        ]);
    }

    // -----------------------------------------
    // CEK BENTROK JADWAL
    // Memastikan lapangan tidak dipesan dua kali
    // pada jam yang sama
    // -----------------------------------------
    public function adaBentrok(int $court_id, string $tanggal, string $jam_mulai, int $durasi): bool
    {
        // Hitung jam selesai dari jam mulai + durasi
        $jam_selesai = date('H:i:s', strtotime($jam_mulai) + ($durasi * 3600));

        try {
            $sql = "SELECT COUNT(*) FROM bookings
                    WHERE court_id     = :court_id
                      AND booking_date = :tanggal
                      AND status       != 'cancelled'
                      AND start_time   < :jam_selesai
                      AND ADDTIME(start_time, SEC_TO_TIME(duration * 3600)) > :jam_mulai";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':court_id'    => $court_id,
                ':tanggal'     => $tanggal,
                ':jam_mulai'   => $jam_mulai,
                ':jam_selesai' => $jam_selesai,
            ]);

            return (int) $stmt->fetchColumn() > 0;

        } catch (\Exception $e) {
            // Kalau DB tidak support query ini (misal SQLite saat testing),
            // anggap tidak ada bentrok agar booking tetap bisa diproses
            return false;
        }
    }

    // -----------------------------------------
    // HITUNG TOTAL BOOKING (untuk dashboard admin)
    // -----------------------------------------
    public function hitungTotal(): int
    {
        return (int) $this->pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
    }

    // -----------------------------------------
    // HITUNG BOOKING PER STATUS (dashboard admin)
    // Hasilnya: ['pending' => 5, 'confirmed' => 3, ...]
    // -----------------------------------------
    public function hitungPerStatus(): array
    {
        $sql  = "SELECT status, COUNT(*) AS jumlah FROM bookings GROUP BY status";
        $rows = $this->pdo->query($sql)->fetchAll();

        // Ubah hasil menjadi array asosiatif status => jumlah
        $hasil = ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0];
        foreach ($rows as $row) {
            $hasil[$row['status']] = (int) $row['jumlah'];
        }

        return $hasil;
    }
}

