<?php

// =============================================
// BOOKING CONTROLLER
// Tanggung jawab: Anggota 3
// =============================================

class BookingController
{
    private ?PDO     $pdo;
    private ?Booking $modelBooking;
    private ?Court   $modelLapangan;

    public function __construct(?PDO $pdo)
    {
        $this->pdo           = $pdo;
        $this->modelBooking  = $pdo ? new Booking($pdo)  : null;
        $this->modelLapangan = $pdo ? new Court($pdo)    : null;
    }

    // -----------------------------------------
    // TAMPIL FORM BOOKING
    // GET /booking?court_id=1
    // -----------------------------------------
    public function tampilFormBooking(): void
    {
        $this->wajibLogin();

        $court_id = (int) ($_GET['court_id'] ?? 0);
        $lapangan = $this->ambilLapangan($court_id);

        if (!$lapangan) {
            header('Location: /courts');
            exit;
        }

        $pesan_error = $_SESSION['error_booking'] ?? null;
        unset($_SESSION['error_booking']);

        require __DIR__ . '/../../views/customer/booking.php';
    }

    // -----------------------------------------
    // SIMPAN BOOKING
    // POST /booking/store
    // -----------------------------------------
    public function simpanBooking(): void
    {
        $this->wajibLogin();

        $user_id   = (int)   $_SESSION['user_id'];
        $court_id  = (int)  ($_POST['court_id']    ?? 0);
        $tanggal   = trim($_POST['booking_date']   ?? '');
        $jam_mulai = trim($_POST['start_time']     ?? '');
        $durasi    = (int)  ($_POST['duration']    ?? 0);

        // Validasi input
        $error = $this->validasiInput($court_id, $tanggal, $jam_mulai, $durasi);
        if ($error) {
            $_SESSION['error_booking'] = $error;
            header("Location: /booking?court_id={$court_id}");
            exit;
        }

        $lapangan = $this->ambilLapangan($court_id);
        if (!$lapangan) {
            $_SESSION['error_booking'] = 'Lapangan tidak ditemukan.';
            header('Location: /courts');
            exit;
        }

        // Hitung total harga: harga per jam × durasi
        $total_harga = $lapangan['price_per_hour'] * $durasi;

        if ($this->modelBooking) {
            // ── Mode production: pakai database ──
            $bentrok = $this->modelBooking->adaBentrok($court_id, $tanggal, $jam_mulai, $durasi);
            if ($bentrok) {
                $_SESSION['error_booking'] = 'Jadwal sudah dipesan. Silakan pilih waktu lain.';
                header("Location: /booking?court_id={$court_id}");
                exit;
            }

            $berhasil = $this->modelBooking->buat([
                'user_id'      => $user_id,
                'court_id'     => $court_id,
                'booking_date' => $tanggal,
                'start_time'   => $jam_mulai,
                'duration'     => $durasi,
                'total_price'  => $total_harga,
            ]);

            if (!$berhasil) {
                $_SESSION['error_booking'] = 'Terjadi kesalahan, coba lagi.';
                header("Location: /booking?court_id={$court_id}");
                exit;
            }

        } else {
            // ── Mode testing: simpan ke session ──
            if (!isset($_SESSION['dummy_bookings'])) {
                $_SESSION['dummy_bookings'] = [];
            }

            $bookingBaru = [
                'id'            => count($_SESSION['dummy_bookings']) + 1,
                'nama_customer' => $_SESSION['name'] ?? 'Tester',
                'nama_lapangan' => $lapangan['name'],
                'jenis_olahraga'=> $lapangan['sport_type'],
                'booking_date'  => $tanggal,
                'start_time'    => $jam_mulai . ':00',
                'duration'      => $durasi,
                'total_price'   => $total_harga,
                'status'        => 'pending',
                'created_at'    => date('Y-m-d H:i:s'),
            ];

            // Taruh di paling atas (terbaru dulu)
            array_unshift($_SESSION['dummy_bookings'], $bookingBaru);
        }

        $_SESSION['sukses_booking'] = 'Booking berhasil! Pesananmu sudah tersimpan.';
        header('Location: /my-bookings');
        exit;
    }

    // -----------------------------------------
    // TAMPIL RIWAYAT BOOKING CUSTOMER
    // GET /my-bookings
    // -----------------------------------------
    public function tampilRiwayatBooking(): void
    {
        $this->wajibLogin();

        if ($this->modelBooking) {
            $daftarBooking = $this->modelBooking->ambilMilikCustomer((int)$_SESSION['user_id']);
        } else {
            $daftarBooking = $_SESSION['dummy_bookings'] ?? [];
        }

        $sukses = $_SESSION['sukses_booking'] ?? null;
        unset($_SESSION['sukses_booking']);

        require __DIR__ . '/../../views/customer/my-bookings.php';
    }

    // -----------------------------------------
    // HELPER: ambil lapangan dari DB atau dummy session
    // -----------------------------------------
    private function ambilLapangan(int $id): ?array
    {
        if ($this->modelLapangan) {
            return $this->modelLapangan->ambilById($id);
        }
        return CourtController::cariDummyById($id);
    }

    // -----------------------------------------
    // HELPER: validasi input form booking
    // -----------------------------------------
    private function validasiInput(int $court_id, string $tanggal, string $jam_mulai, int $durasi): ?string
    {
        if ($court_id <= 0)          return 'Lapangan tidak valid.';
        if (empty($tanggal))         return 'Tanggal main wajib diisi.';
        if ($tanggal < date('Y-m-d')) return 'Tanggal tidak boleh di masa lalu.';
        if (empty($jam_mulai))       return 'Jam mulai wajib diisi.';
        if ($durasi < 1 || $durasi > 8) return 'Durasi harus 1–8 jam.';
        return null;
    }

    // -----------------------------------------
    // HELPER: wajib login (bypass jika sudah ada session)
    // -----------------------------------------
    private function wajibLogin(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
