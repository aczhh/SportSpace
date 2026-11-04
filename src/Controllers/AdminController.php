<?php

// =============================================
// ADMIN CONTROLLER
// Tanggung jawab: Anggota 3 (booking & dashboard)
//                 Anggota 2 (CRUD lapangan)
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

    // -----------------------------------------
    // GET /admin
    // Dashboard admin – Anggota 3
    // -----------------------------------------
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

    // -----------------------------------------
    // GET /admin/bookings
    // Kelola booking – Anggota 3
    // -----------------------------------------
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

    // -----------------------------------------
    // POST /admin/bookings/update-status
    // Update status booking – Anggota 3
    // -----------------------------------------
    public function updateStatusBooking(): void
    {
        $this->wajibAdmin();

        $booking_id  = (int)  ($_POST['booking_id'] ?? 0);
        $status      = trim($_POST['status']        ?? '');
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

    // -----------------------------------------
    // GET /admin/courts
    // Tampil daftar lapangan – Anggota 2
    // -----------------------------------------
    public function tampilKelolaLapangan(): void
    {
        $this->wajibAdmin();

        $daftarLapangan = $this->modelLapangan
            ? $this->modelLapangan->ambilSemua()
            : ($_SESSION['dummy_courts'] ?? []);

        $sukses = $_SESSION['sukses_admin'] ?? null;
        $error  = $_SESSION['error_admin']  ?? null;
        unset($_SESSION['sukses_admin'], $_SESSION['error_admin']);

        require __DIR__ . '/../../views/admin/courts.php';
    }

    // -----------------------------------------
    // POST /admin/courts/store
    // Simpan lapangan baru – Anggota 2
    // -----------------------------------------
    public function simpanLapangan(): void
    {
        $this->wajibAdmin();

        // Ambil dan bersihkan input dari form
        $name           = trim($_POST['name']          ?? '');
        $sport_type     = trim($_POST['sport_type']    ?? '');
        $description    = trim($_POST['description']   ?? '');
        $facilities     = trim($_POST['facilities']    ?? '');
        $price_per_hour = trim($_POST['price_per_hour']?? '');
        $image          = trim($_POST['image']         ?? 'court.jpg');

        // Validasi input wajib
        $error = $this->validasiInputLapangan($name, $sport_type, $price_per_hour);
        if ($error) {
            $_SESSION['error_admin']   = $error;
            $_SESSION['form_lapangan'] = $_POST; // simpan isian form agar tidak hilang
            header('Location: /admin/courts');
            exit;
        }

        if ($this->modelLapangan) {
            $berhasil = $this->modelLapangan->buat([
                'name'          => $name,
                'sport_type'    => $sport_type,
                'description'   => $description,
                'facilities'    => $facilities,
                'price_per_hour'=> (float) $price_per_hour,
                'image'         => $image ?: 'court.jpg',
            ]);

            if ($berhasil) {
                $_SESSION['sukses_admin'] = 'Lapangan "' . $name . '" berhasil ditambahkan.';
            } else {
                $_SESSION['error_admin'] = 'Gagal menyimpan lapangan. Coba lagi.';
            }
        } else {
            // Mode testing: simpan ke session dummy
            $semuaCourt   = $_SESSION['dummy_courts'] ?? [];
            $semuaCourt[] = [
                'id'            => count($semuaCourt) + 1,
                'name'          => $name,
                'sport_type'    => $sport_type,
                'description'   => $description,
                'facilities'    => $facilities,
                'price_per_hour'=> (float) $price_per_hour,
                'image'         => $image ?: 'court.jpg',
                'created_at'    => date('Y-m-d H:i:s'),
            ];
            $_SESSION['dummy_courts'] = $semuaCourt;
            $_SESSION['sukses_admin'] = 'Lapangan "' . $name . '" berhasil ditambahkan.';
        }

        header('Location: /admin/courts');
        exit;
    }

    // -----------------------------------------
    // POST /admin/courts/update
    // Update data lapangan – Anggota 2
    // -----------------------------------------
    public function updateLapangan(): void
    {
        $this->wajibAdmin();

        $id             = (int)  ($_POST['id']           ?? 0);
        $name           = trim($_POST['name']             ?? '');
        $sport_type     = trim($_POST['sport_type']       ?? '');
        $description    = trim($_POST['description']      ?? '');
        $facilities     = trim($_POST['facilities']       ?? '');
        $price_per_hour = trim($_POST['price_per_hour']   ?? '');
        $image          = trim($_POST['image']            ?? 'court.jpg');

        // Validasi: id harus ada
        if ($id <= 0) {
            $_SESSION['error_admin'] = 'Lapangan tidak ditemukan.';
            header('Location: /admin/courts');
            exit;
        }

        // Validasi input wajib
        $error = $this->validasiInputLapangan($name, $sport_type, $price_per_hour);
        if ($error) {
            $_SESSION['error_admin'] = $error;
            header('Location: /admin/courts');
            exit;
        }

        if ($this->modelLapangan) {
            $berhasil = $this->modelLapangan->update($id, [
                'name'          => $name,
                'sport_type'    => $sport_type,
                'description'   => $description,
                'facilities'    => $facilities,
                'price_per_hour'=> (float) $price_per_hour,
                'image'         => $image ?: 'court.jpg',
            ]);

            if ($berhasil) {
                $_SESSION['sukses_admin'] = 'Lapangan "' . $name . '" berhasil diperbarui.';
            } else {
                $_SESSION['error_admin'] = 'Gagal memperbarui lapangan. Coba lagi.';
            }
        } else {
            // Mode testing: update di session dummy
            foreach ($_SESSION['dummy_courts'] as &$court) {
                if ((int)$court['id'] === $id) {
                    $court['name']          = $name;
                    $court['sport_type']    = $sport_type;
                    $court['description']   = $description;
                    $court['facilities']    = $facilities;
                    $court['price_per_hour']= (float) $price_per_hour;
                    $court['image']         = $image ?: 'court.jpg';
                    break;
                }
            }
            unset($court); // putus referensi
            $_SESSION['sukses_admin'] = 'Lapangan "' . $name . '" berhasil diperbarui.';
        }

        header('Location: /admin/courts');
        exit;
    }

    // -----------------------------------------
    // POST /admin/courts/delete
    // Hapus lapangan – Anggota 2
    // -----------------------------------------
    public function hapusLapangan(): void
    {
        $this->wajibAdmin();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error_admin'] = 'Lapangan tidak ditemukan.';
            header('Location: /admin/courts');
            exit;
        }

        if ($this->modelLapangan) {
            $this->modelLapangan->hapus($id);
        } else {
            // Mode testing: hapus dari session dummy
            $_SESSION['dummy_courts'] = array_values(
                array_filter($_SESSION['dummy_courts'] ?? [], fn($c) => (int)$c['id'] !== $id)
            );
        }

        $_SESSION['sukses_admin'] = 'Lapangan berhasil dihapus.';
        header('Location: /admin/courts');
        exit;
    }

    // -----------------------------------------
    // HELPER: validasi input form lapangan
    // -----------------------------------------
    private function validasiInputLapangan(string $name, string $sport_type, string $price_per_hour): ?string
    {
        if (empty($name))                    return 'Nama lapangan wajib diisi.';
        if (empty($sport_type))              return 'Jenis olahraga wajib dipilih.';
        if (!is_numeric($price_per_hour))    return 'Harga per jam harus berupa angka.';
        if ((float)$price_per_hour <= 0)     return 'Harga per jam harus lebih dari 0.';
        return null;
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
