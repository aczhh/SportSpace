<?php

// =============================================
// ADMIN CONTROLLER
// Tanggung jawab: Anggota 3
// =============================================

class AdminController
{
    private ?PDO     $pdo;
    private ?Booking $modelBooking;
    private ?Court   $modelLapangan;

    public function __construct(?PDO $pdo)
    {
        $this->pdo           = $pdo;
        $this->modelBooking  = $pdo ? new Booking($pdo) : null;
        $this->modelLapangan = $pdo ? new Court($pdo)   : null;
    }

    // GET /admin
    public function tampilDashboard(): void
    {
        $this->wajibAdmin();

        if ($this->modelBooking) {
            $jumlahLapangan   = $this->modelLapangan->hitungTotal();
            $jumlahBooking    = $this->modelBooking->hitungTotal();
            $bookingPerStatus = $this->modelBooking->hitungPerStatus();
        } else {
            $semuaBooking     = $_SESSION['dummy_bookings'] ?? [];
            $jumlahLapangan   = count($_SESSION['dummy_courts'] ?? []);
            $jumlahBooking    = count($semuaBooking);
            $bookingPerStatus = ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0];
            foreach ($semuaBooking as $b) {
                $st = $b['status'] ?? 'pending';
                $bookingPerStatus[$st] = ($bookingPerStatus[$st] ?? 0) + 1;
            }
        }

        require __DIR__ . '/../../views/admin/dashboard.php';
    }

    // GET /admin/bookings
    public function tampilKelolaBooking(): void
    {
        $this->wajibAdmin();

        if ($this->modelBooking) {
            $daftarBooking = $this->modelBooking->ambilSemua();
        } else {
            $daftarBooking = $_SESSION['dummy_bookings'] ?? [];
        }

        $sukses = $_SESSION['sukses_admin'] ?? null;
        unset($_SESSION['sukses_admin']);

        require __DIR__ . '/../../views/admin/bookings.php';
    }

    // POST /admin/bookings/update-status
    public function updateStatusBooking(): void
    {
        $this->wajibAdmin();

        $booking_id = (int)  ($_POST['booking_id'] ?? 0);
        $status     = trim($_POST['status']       ?? '');
        $statusValid = ['pending', 'confirmed', 'cancelled'];

        if ($booking_id > 0 && in_array($status, $statusValid)) {
            if ($this->modelBooking) {
                $this->modelBooking->updateStatus($booking_id, $status);
            } else {
                // Update status di session dummy
                foreach ($_SESSION['dummy_bookings'] as &$booking) {
                    if ((int)$booking['id'] === $booking_id) {
                        $booking['status'] = $status;
                        break;
                    }
                }
                unset($booking); // putus referensi
            }
            $_SESSION['sukses_admin'] = 'Status booking #' . $booking_id . ' berhasil diubah ke "' . $status . '".';
        }

        header('Location: /admin/bookings');
        exit;
    }

    // GET /admin/courts – Tanggung jawab Anggota 2
    public function tampilKelolaLapangan(): void
    {
        $this->wajibAdmin();

        $daftarLapangan = $this->modelLapangan
            ? $this->modelLapangan->ambilSemua()
            : ($_SESSION['dummy_courts'] ?? []);

        $sukses = $_SESSION['sukses_admin'] ?? null;
        unset($_SESSION['sukses_admin']);

        require __DIR__ . '/../../views/admin/courts.php';
    }

    // POST /admin/courts/store – TODO Anggota 2
    public function simpanLapangan(): void
    {
        $this->wajibAdmin();
        header('Location: /admin/courts');
        exit;
    }

    // POST /admin/courts/update – TODO Anggota 2
    public function updateLapangan(): void
    {
        $this->wajibAdmin();
        header('Location: /admin/courts');
        exit;
    }

    // POST /admin/courts/delete – TODO Anggota 2
    public function hapusLapangan(): void
    {
        $this->wajibAdmin();
        header('Location: /admin/courts');
        exit;
    }

    // -----------------------------------------
    // HELPER: hanya admin yang bisa akses
    // -----------------------------------------
    private function wajibAdmin(): void
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }
    }
}
