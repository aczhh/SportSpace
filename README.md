# SportSpace – Sports Facility Booking

**Find Your Court, Book Your Game.**

SportSpace adalah aplikasi berbasis web yang digunakan untuk melihat informasi dan melakukan pemesanan lapangan olahraga, seperti futsal, badminton, dan basket.

Aplikasi ini dibuat sebagai proyek kelompok mata kuliah Pemrograman Web dengan menerapkan arsitektur MVC menggunakan PHP Native dan database MySQL.

## 1. Tujuan Proyek

- Memudahkan customer mencari informasi lapangan olahraga.
- Memungkinkan customer melakukan pemesanan lapangan secara online.
- Memudahkan customer melihat riwayat pemesanan.
- Membantu admin mengelola data lapangan dan pemesanan.
- Menerapkan arsitektur MVC menggunakan PHP Native.
- Menggunakan MySQL dengan PDO dan prepared statements.
- Menerapkan kolaborasi pengembangan menggunakan Git dan GitHub.

## 2. Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP Native | Backend aplikasi |
| MySQL | Menyimpan data aplikasi |
| PDO | Menghubungkan PHP dengan database |
| HTML | Membuat struktur halaman |
| CSS | Mengatur tampilan website |
| JavaScript | Menambahkan interaksi halaman |
| Git & GitHub | Mengelola kode dan kolaborasi kelompok |

Proyek menggunakan PHP Native tanpa framework backend seperti Laravel. Tampilan website dibuat menggunakan HTML, CSS, dan JavaScript tanpa framework CSS tambahan.

## 3. Peran Pengguna

SportSpace memiliki dua jenis pengguna, yaitu Customer dan Admin.

### A. Customer

Customer adalah pengguna yang ingin mencari dan memesan lapangan olahraga.

Fitur yang dapat digunakan:
- Membuat akun melalui halaman register.
- Login dan logout.
- Melihat halaman utama SportSpace.
- Melihat daftar lapangan yang tersedia.
- Melihat detail, fasilitas, dan harga lapangan.
- Melakukan pemesanan dengan memilih tanggal, jam mulai, dan durasi.
- Melihat riwayat pemesanan melalui halaman My Booking.

### B. Admin

Admin adalah pengguna yang bertugas mengelola data aplikasi.

Fitur yang dapat digunakan:
- Login dan logout.
- Melihat dashboard admin.
- Melihat ringkasan jumlah lapangan dan pemesanan.
- Menambahkan data lapangan.
- Mengubah data lapangan.
- Menghapus data lapangan.
- Melihat seluruh data pemesanan.
- Mengubah status pemesanan menjadi pending, confirmed, atau cancelled.

Akun admin disediakan melalui data awal (seed) pada database. Admin tidak perlu melakukan registrasi melalui aplikasi.

## 4. Fitur Utama Aplikasi

### A. Fitur Customer

| Fitur | Deskripsi |
|---|---|
| Register | Membuat akun customer baru. |
| Login | Masuk menggunakan email dan password. |
| Home | Menampilkan halaman utama SportSpace. |
| Daftar Lapangan | Menampilkan daftar lapangan olahraga. |
| Detail Lapangan | Menampilkan informasi, fasilitas, dan harga lapangan. |
| Booking Lapangan | Memilih tanggal, jam mulai, dan durasi pemesanan. |
| My Booking | Menampilkan riwayat pemesanan milik customer yang sedang login. |
| Logout | Keluar dari akun customer. |

### B. Fitur Admin

| Fitur | Deskripsi |
|---|---|
| Login Admin | Masuk menggunakan akun admin yang tersedia. |
| Dashboard | Menampilkan ringkasan jumlah lapangan dan pemesanan. |
| Kelola Lapangan | Menambah, melihat, mengubah, dan menghapus data lapangan. |
| Kelola Booking | Melihat seluruh data pemesanan customer. |
| Update Status | Mengubah status pemesanan menjadi pending, confirmed, atau cancelled. |
| Logout | Keluar dari akun admin. |

### Alur Penggunaan Customer

1. Customer membuka website SportSpace.
2. Customer melakukan register jika belum memiliki akun.
3. Customer login menggunakan email dan password.
4. Customer melihat daftar lapangan.
5. Customer memilih lapangan yang diinginkan.
6. Customer melihat detail dan harga lapangan.
7. Customer memilih tanggal, jam mulai, dan durasi bermain.
8. Customer mengirim formulir pemesanan.
9. Sistem memvalidasi data dan menyimpan pemesanan ke database.
10. Customer dapat melihat pemesanannya melalui halaman My Booking.

### Alur Penggunaan Admin

1. Admin membuka halaman login.
2. Admin masuk menggunakan akun yang sudah disediakan.
3. Admin diarahkan ke dashboard.
4. Admin dapat mengelola data lapangan.
5. Admin dapat melihat seluruh pemesanan customer.
6. Admin dapat mengubah status pemesanan.

## 5. Batasan Proyek

Agar proyek dapat diselesaikan sesuai waktu pengerjaan, pengembangan difokuskan pada fitur utama aplikasi.

**Fitur yang menjadi prioritas:**
- Register, login, dan logout.
- Pembatasan akses berdasarkan role customer dan admin.
- Menampilkan daftar dan detail lapangan.
- CRUD data lapangan oleh admin.
- Formulir dan penyimpanan pemesanan.
- Halaman My Booking.
- Menampilkan seluruh data pemesanan pada halaman admin.
- Mengubah status pemesanan.

**Fitur tambahan jika waktu memungkinkan:**
- Pengecekan bentrok jadwal pemesanan.
- Fitur pembatalan pemesanan oleh customer.
- Filter lapangan berdasarkan jenis olahraga.
- Penyempurnaan tampilan website.

**Fitur yang tidak termasuk dalam proyek:**
- Pembayaran online atau payment gateway.
- Verifikasi email.
- Login menggunakan akun Google.
- Fitur lupa password.
- Notifikasi WhatsApp atau email otomatis.
- Integrasi Google Maps.
- Sistem membership.

## 6. Rancangan Database

Database yang digunakan bernama `sportspace_db` dan terdiri dari tiga tabel utama.

### A. Tabel `users`

Menyimpan informasi akun customer dan admin.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key, Auto Increment |
| name | VARCHAR(100) | Nama pengguna |
| email | VARCHAR(100) | Email pengguna, unik |
| password | VARCHAR(255) | Password yang sudah di-hash |
| role | ENUM('customer','admin') | Peran pengguna |
| created_at | TIMESTAMP | Waktu pembuatan akun |

### B. Tabel `courts`

Menyimpan informasi lapangan olahraga.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key, Auto Increment |
| name | VARCHAR(100) | Nama lapangan |
| sport_type | VARCHAR(50) | Jenis olahraga |
| description | TEXT | Deskripsi lapangan |
| facilities | TEXT | Fasilitas lapangan |
| price_per_hour | DECIMAL(10,2) | Harga per jam |
| image | VARCHAR(255) | URL atau nama file gambar |
| created_at | TIMESTAMP | Waktu pembuatan data |

### C. Tabel `bookings`

Menyimpan informasi pemesanan lapangan oleh customer.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key, Auto Increment |
| user_id | INT | Foreign Key ke users.id |
| court_id | INT | Foreign Key ke courts.id |
| booking_date | DATE | Tanggal bermain |
| start_time | TIME | Jam mulai |
| duration | INT | Durasi pemesanan dalam jam |
| total_price | DECIMAL(10,2) | Total harga pemesanan |
| status | ENUM('pending','confirmed','cancelled') | Status pemesanan |
| created_at | TIMESTAMP | Waktu pemesanan |

### Relasi Database

- Satu user dapat memiliki banyak pemesanan.
- Satu lapangan dapat memiliki banyak pemesanan.
- Setiap pemesanan dimiliki oleh satu user dan satu lapangan.

Total harga pemesanan dihitung menggunakan rumus:

`total_price = price_per_hour × duration`

Pengecekan bentrok jadwal dilakukan agar lapangan yang sama tidak dipesan pada waktu yang bertabrakan.

## 7. Arsitektur MVC

Aplikasi menggunakan konsep Model-View-Controller (MVC) untuk memisahkan pengolahan data, tampilan, dan alur aplikasi.

### Model

Bertugas mengelola data dan berkomunikasi dengan database menggunakan PDO dan prepared statements.

Contoh:
- `User.php`
- `Court.php`
- `Booking.php`

### View

Bertugas menampilkan halaman yang dilihat oleh customer dan admin. View menggunakan PHP dan HTML untuk menampilkan data.

Contoh:
- `home.php`
- `courts.php`
- `booking.php`
- `my-bookings.php`
- `dashboard.php`

View tidak digunakan untuk menjalankan query SQL secara langsung.

### Controller

Bertugas menerima request dari pengguna, melakukan validasi input, memanggil Model, dan menentukan View yang akan ditampilkan.

Contoh:
- `AuthController.php`
- `CourtController.php`
- `BookingController.php`
- `AdminController.php`

### Alur Request

Browser → `public/index.php` → Router → Controller → Model → Database

Setelah data diproses, Controller mengirimkan data ke View untuk ditampilkan kepada pengguna.

## 8. Struktur Folder

```text
sportspace/
│
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   ├── js/
│   └── images/
│
├── src/
│   ├── Core/
│   │   └── Router.php
│   │
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── CourtController.php
│   │   ├── BookingController.php
│   │   └── AdminController.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Court.php
│   │   └── Booking.php
│   │
│   └── Config/
│       └── koneksi.php
│
├── views/
│   ├── layout/
│   │   ├── header.php
│   │   └── footer.php
│   │
│   ├── auth/
│   │   ├── login.php
│   │   └── register.php
│   │
│   ├── customer/
│   │   ├── home.php
│   │   ├── courts.php
│   │   ├── detail.php
│   │   ├── booking.php
│   │   └── my-bookings.php
│   │
│   └── admin/
│       ├── dashboard.php
│       ├── courts.php
│       ├── court-form.php
│       └── bookings.php
│
├── database/
│   └── sportspace_db.sql
│
├── .gitignore
└── README.md
```

Struktur folder dapat disesuaikan selama pemisahan Model, View, dan Controller tetap diterapkan.

## 9. Rancangan Route

Route digunakan untuk menentukan halaman atau proses yang dijalankan berdasarkan request pengguna.

| Method | Route | Fungsi |
|---|---|---|
| GET | `/` | Menampilkan halaman utama |
| GET | `/courts` | Menampilkan daftar lapangan |
| GET | `/courts/detail?id=1` | Menampilkan detail lapangan |
| GET | `/register` | Menampilkan halaman register |
| GET | `/login` | Menampilkan halaman login |
| GET | `/booking?court_id=1` | Menampilkan formulir pemesanan |
| GET | `/my-bookings` | Menampilkan riwayat pemesanan customer |
| GET | `/admin` | Menampilkan dashboard admin |
| GET | `/admin/courts` | Menampilkan data lapangan |
| GET | `/admin/bookings` | Menampilkan data pemesanan |
| POST | `/register` | Memproses registrasi customer |
| POST | `/login` | Memproses login |
| POST | `/logout` | Memproses logout |
| POST | `/booking/store` | Menyimpan pemesanan |
| POST | `/admin/courts/store` | Menambahkan data lapangan |
| POST | `/admin/courts/update` | Mengubah data lapangan |
| POST | `/admin/courts/delete` | Menghapus data lapangan |
| POST | `/admin/bookings/update-status` | Mengubah status pemesanan |

Semua input dari pengguna harus divalidasi di Controller sebelum diproses lebih lanjut.

Setelah request POST berhasil diproses, aplikasi menggunakan redirect agar data tidak terkirim ulang ketika halaman di-refresh.

## 10. Pembagian Tugas Kelompok

Proyek dikerjakan oleh tiga anggota dengan pembagian berdasarkan modul utama aplikasi.

### Anggota 1 – Authentication & User Management

**Tanggung jawab: pengelolaan akun dan hak akses pengguna.**

Fitur yang dikerjakan:
- Halaman register dan login.
- Proses registrasi customer.
- Proses login dan logout.
- Password hashing menggunakan `password_hash()`.
- Verifikasi password menggunakan `password_verify()`.
- Pengelolaan session.
- Pembatasan akses berdasarkan role customer dan admin.
- Menampilkan halaman My Booking berdasarkan akun customer yang sedang login.

File utama:
- `AuthController.php`
- `User.php`
- View pada folder `auth/`
- Bagian My Booking pada folder `customer/`

### Anggota 2 – Court Management

**Tanggung jawab: pengelolaan informasi lapangan olahraga.**

Fitur yang dikerjakan:
- Halaman utama.
- Halaman daftar lapangan.
- Halaman detail lapangan.
- Menambahkan data lapangan.
- Mengubah data lapangan.
- Menghapus data lapangan.
- Menampilkan informasi harga dan fasilitas.
- Validasi input data lapangan.

File utama:
- `CourtController.php`
- `Court.php`
- View pada folder `customer/` dan bagian pengelolaan lapangan di `admin/`.

### Anggota 3 – Booking Management

**Tanggung jawab: proses dan pengelolaan pemesanan.**

Fitur yang dikerjakan:
- Formulir pemesanan.
- Memproses dan menyimpan data booking.
- Validasi data pemesanan.
- Menghitung total harga.
- Menampilkan seluruh data booking pada halaman admin.
- Mengubah status pemesanan oleh admin.
- Pengecekan bentrok jadwal jika waktu memungkinkan.

File utama:
- `BookingController.php`
- `Booking.php`
- View booking pada folder `customer/` dan `admin/`.

### Pekerjaan Bersama

Beberapa pekerjaan dilakukan bersama oleh seluruh anggota:
- Menentukan desain dan tampilan website.
- Menyiapkan database dan relasinya.
- Membuat struktur awal proyek MVC.
- Menyiapkan Router dan koneksi database.
- Mengintegrasikan seluruh fitur.
- Melakukan testing dan memperbaiki bug.
- Melakukan review Pull Request.
- Menyiapkan dokumentasi dan demo aplikasi.

Setiap anggota tetap perlu memahami alur aplikasi secara keseluruhan, bukan hanya bagian yang dikerjakan sendiri.

## 11. Aturan Kolaborasi Git & GitHub

Proyek menggunakan satu repository GitHub yang dikerjakan bersama.

Setiap anggota mengerjakan fitur melalui branch masing-masing.

Contoh nama branch:
- `feature/auth-user`
- `feature/court-management`
- `feature/booking-management`

### Alur Kerja Git

1. Clone repository ke komputer masing-masing.
2. Ambil perubahan terbaru dari branch utama.
3. Buat atau pindah ke branch sesuai fitur yang dikerjakan.
4. Kerjakan fitur pada branch masing-masing.
5. Lakukan commit secara berkala dengan pesan yang jelas.
6. Push branch ke GitHub.
7. Buat Pull Request (PR) menuju branch `main`.
8. Anggota lain melakukan review terhadap kode.
9. Perbaiki kode jika terdapat masukan.
10. Merge ke branch utama setelah disetujui.

### Contoh Perintah Git

```bash
git add .
git commit -m "feat: add court listing page"
git push origin feature/court-management
```

### Contoh Pesan Commit

- `feat: add customer registration`
- `feat: add admin login`
- `feat: add court listing page`
- `feat: implement booking form`
- `fix: validate booking input`
- `style: improve home page`
- `docs: update readme`

Setiap anggota wajib memiliki kontribusi commit dan melakukan review terhadap pekerjaan anggota lain.

## 12. Cara Menjalankan Aplikasi

1. Clone repository SportSpace.
2. Simpan folder proyek di dalam folder `htdocs` jika menggunakan XAMPP.
3. Jalankan Apache dan MySQL melalui XAMPP.
4. Buat database dengan nama `sportspace_db`.
5. Import file `database/sportspace_db.sql` melalui phpMyAdmin.
6. Sesuaikan konfigurasi database pada `src/Config/koneksi.php`.
7. Buka aplikasi melalui browser menggunakan alamat lokal yang telah dikonfigurasi.

### Akun Pengguna

**Admin:**

Akun admin disediakan melalui data awal pada database. Informasi email dan password demo akan dicantumkan setelah data seed dibuat.

**Customer:**

Customer dapat membuat akun melalui halaman Register.

## 13. Checklist Ketentuan Tugas

Target implementasi proyek berdasarkan ketentuan tugas:

- [ ] Dikerjakan oleh kelompok beranggotakan tiga orang dengan satu repository GitHub.
- [ ] Menggunakan PHP dengan arsitektur MVC.
- [ ] Menggunakan database MySQL, PDO, dan prepared statements.
- [ ] Memiliki minimal dua tabel database.
- [ ] Menerapkan fitur CRUD.
- [ ] Memiliki minimal dua GET route dan dua POST route.
- [ ] Melakukan validasi input di Controller.
- [ ] Menggunakan branch untuk setiap fitur.
- [ ] Menggunakan Pull Request dan melakukan peer review.

**Deadline pengumpulan: 8 November 2026, pukul 23.59 WIB.**

---

**SportSpace – Find Your Court, Book Your Game.**