# SportSpace – Sports Facility Booking

Aplikasi web sederhana untuk melihat dan memesan lapangan olahraga (futsal, badminton, basket, dll). Dibuat sebagai proyek kelompok mata kuliah Pemrograman Web.

**Tagline:** Find Your Court, Book Your Game.

## 1. Tujuan

- Customer bisa melihat daftar lapangan dan memesannya secara online.
- Admin bisa mengelola data lapangan dan status pemesanan.
- Menerapkan arsitektur MVC dengan PHP Native (tanpa framework).
- Menggunakan MySQL dengan PDO dan prepared statement.
- Berkolaborasi menggunakan Git dan GitHub (branch, commit, Pull Request, review).

## 2. Teknologi

| Teknologi | Kegunaan |
|---|---|
| PHP Native (MVC) | Backend |
| MySQL + PDO | Database |
| HTML, CSS, JavaScript | Tampilan |
| Git & GitHub | Kolaborasi |

## 3. Peran Pengguna

**Customer**
- Register dan login
- Melihat daftar dan detail lapangan
- Memesan lapangan (pilih tanggal, jam mulai, dan durasi)
- Melihat riwayat pemesanan (My Booking)

**Admin**
- Login
- CRUD data lapangan
- Melihat semua pemesanan
- Mengubah status pemesanan (pending / confirmed / cancelled)

## 4. Prioritas Fitur

Dikerjakan berurutan sesuai prioritas, karena waktu pengerjaan terbatas.

**Prioritas 1 (wajib selesai)**
- Daftar lapangan dan detail lapangan
- CRUD lapangan oleh admin
- Form booking dan simpan booking
- Halaman My Booking

**Prioritas 2**
- Register, login, logout (password_hash + session)
- Pembatasan akses admin dan customer
- Admin mengubah status booking

**Prioritas 3 (jika sempat)**
- Pengecekan jadwal bentrok
- Mempercantik tampilan
- Fitur batal booking oleh customer

**Tidak dikerjakan:** pembayaran online, upload gambar (gambar cukup pakai URL/nama file), notifikasi, Google Maps, membership.

## 5. Rancangan Database

Nama database: `sportspace_db` (3 tabel).

**users**

| Field | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary Key, auto increment |
| name | VARCHAR(100) | Nama |
| email | VARCHAR(100) | Email (unik) |
| password | VARCHAR(255) | Password ter-hash |
| role | ENUM('customer','admin') | Peran |
| created_at | TIMESTAMP | Waktu dibuat |

**courts**

| Field | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary Key, auto increment |
| name | VARCHAR(100) | Nama lapangan |
| sport_type | VARCHAR(50) | Jenis olahraga |
| description | TEXT | Deskripsi |
| facilities | TEXT | Fasilitas |
| price_per_hour | DECIMAL(10,2) | Harga per jam |
| image | VARCHAR(255) | URL/nama file gambar |
| created_at | TIMESTAMP | Waktu dibuat |

**bookings**

| Field | Tipe | Keterangan |
|---|---|---|
| id | INT | Primary Key, auto increment |
| user_id | INT | FK ke users.id |
| court_id | INT | FK ke courts.id |
| booking_date | DATE | Tanggal main |
| start_time | TIME | Jam mulai |
| duration | INT | Durasi (jam) |
| total_price | DECIMAL(10,2) | duration x price_per_hour |
| status | ENUM('pending','confirmed','cancelled') | Default: pending |
| created_at | TIMESTAMP | Waktu dibuat |

**Relasi:** satu user punya banyak booking, satu court punya banyak booking.

Akun admin dibuat langsung lewat data awal (seed) di database, jadi tidak perlu halaman khusus.

## 6. Arsitektur MVC

- **Model**: berisi query database (PDO + prepared statement). Satu file per tabel.
- **View**: tampilan PHP + HTML, tanpa SQL. Gunakan `htmlspecialchars` saat menampilkan data.
- **Controller**: menerima request, validasi input, memanggil Model, lalu memilih View.

Alur request: Browser → `public/index.php` (front controller) → Router → Controller → Model → View.

## 7. Struktur Folder

```text
sportspace/
├── public/
│   ├── index.php          # front controller (satu pintu)
│   ├── .htaccess
│   ├── css/
│   ├── js/
│   └── images/
├── src/
│   ├── Core/
│   │   └── Router.php
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── CourtController.php
│   │   ├── BookingController.php
│   │   └── AdminController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Court.php
│   │   └── Booking.php
│   └── config/
│       └── koneksi.php
├── views/
│   ├── layout/            # header, footer
│   ├── auth/              # login, register
│   ├── customer/          # home, courts, detail, booking, my-bookings
│   └── admin/             # dashboard, courts, bookings
├── database/
│   └── sportspace_db.sql  # struktur tabel + data awal
├── .gitignore
└── README.md
```

## 8. Rancangan Route

| Method | Route | Fungsi |
|---|---|---|
| GET | `/` | Halaman utama |
| GET | `/courts` | Daftar lapangan |
| GET | `/courts/detail` | Detail lapangan (id lewat query `?id=1`) |
| GET | `/booking` | Form booking |
| GET | `/my-bookings` | Riwayat booking customer |
| GET | `/login` | Halaman login |
| GET | `/register` | Halaman register |
| GET | `/admin` | Dashboard admin |
| POST | `/login` | Proses login |
| POST | `/register` | Proses registrasi |
| POST | `/logout` | Logout |
| POST | `/booking/store` | Simpan booking |
| POST | `/admin/courts/store` | Tambah lapangan |
| POST | `/admin/courts/update` | Ubah lapangan |
| POST | `/admin/courts/delete` | Hapus lapangan |
| POST | `/admin/bookings/update-status` | Ubah status booking |

Semua input divalidasi di Controller sebelum diproses. Setelah POST berhasil, gunakan redirect (pola PRG: `header('Location: ...')` lalu `exit`).

## 9. Pembagian Tugas

**Anggota 1 – Auth**
- Register, login, logout, password hashing, session, pembatasan akses role
- File: `AuthController.php`, `User.php`, `views/auth/`

**Anggota 2 – Court**
- Home, daftar lapangan, detail lapangan, CRUD lapangan (admin), validasi input
- File: `CourtController.php`, `Court.php`, view lapangan di `customer/` dan `admin/`

**Anggota 3 – Booking**
- Form booking, simpan booking, hitung total harga, My Booking, ubah status oleh admin, cek bentrok jadwal (prioritas 3)
- File: `BookingController.php`, `Booking.php`, view booking di `customer/` dan `admin/`

**Dikerjakan bersama**
- Setup repo, struktur folder, `Router.php`, `koneksi.php`, dan file SQL di hari pertama
- Desain tampilan dasar (header, footer, CSS)
- Integrasi, testing, dan perbaikan bug
- Persiapan demo

## 10. Aturan Git & GitHub

Satu repository bersama. Setiap anggota bekerja di branch sendiri:
- `feature/auth`
- `feature/court`
- `feature/booking`

Alur kerja:
1. Clone repository dan `git pull` dari branch `main`.
2. Pindah ke branch fitur masing-masing.
3. Kerjakan fitur, lalu commit sering dengan pesan yang jelas.
4. Push branch ke GitHub.
5. Buat Pull Request ke `main`.
6. Minimal 1 anggota lain me-review dan memberi komentar.
7. Merge setelah disetujui.

Contoh commit:
```bash
git add .
git commit -m "feat: add court listing page"
git push origin feature/court
```

Contoh pesan commit: `feat: add user login`, `fix: booking total price`, `style: improve navbar`, `docs: update readme`.

## 11. Cara Menjalankan

1. Clone repository ini.
2. Buat database `sportspace_db`, lalu import `database/sportspace_db.sql`.
3. Sesuaikan username dan password MySQL di `src/config/koneksi.php`.
4. Jalankan lewat XAMPP (taruh folder di `htdocs`), atau gunakan PHP built-in server:
   `php -S localhost:8000 -t public`
5. Buka `http://localhost:8000` di browser.

**Akun admin awal:** (isi sesuai data seed, contoh: admin@sportspace.com / admin123)

## 12. Checklist Ketentuan Tugas

- [x] Kelompok 3 orang, 1 repository GitHub
- [x] PHP MVC + MySQL (PDO, prepared statement)
- [x] Minimal 2 tabel (kami pakai 3)
- [x] CRUD lengkap (data lapangan)
- [x] Minimal 2 route GET dan 2 route POST
- [x] Validasi input di Controller
- [x] Branch per fitur, Pull Request, dan review rekan

**Deadline: 8 November 2026, pukul 23.59 WIB**