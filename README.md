# SportSpace – Sports Facility Booking System

SportSpace adalah aplikasi berbasis web yang digunakan untuk memudahkan pengguna dalam mencari dan melakukan pemesanan fasilitas olahraga, seperti lapangan futsal, badminton, basket, dan fasilitas olahraga lainnya.

Melalui SportSpace, pengguna dapat melihat daftar lapangan, mengetahui informasi fasilitas, memilih tanggal dan jam bermain, serta melakukan pemesanan secara online. Admin dapat mengelola data lapangan dan memantau pemesanan yang dilakukan oleh pengguna.

## 1. Tujuan Proyek

- Memudahkan pengguna mencari fasilitas olahraga.
- Mempermudah proses pemesanan lapangan tanpa harus datang langsung.
- Membantu pengelola mengatur informasi lapangan dan data pemesanan.
- Menerapkan konsep arsitektur MVC menggunakan PHP.
- Mengimplementasikan database MySQL dengan PDO dan prepared statements.
- Menerapkan kolaborasi pengembangan perangkat lunak menggunakan Git dan GitHub.

## 2. Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP Native | Backend aplikasi |
| MySQL | Menyimpan data aplikasi |
| PDO | Menghubungkan PHP dengan database |
| HTML | Membuat struktur halaman |
| CSS | Mengatur tampilan website |
| JavaScript | Interaksi pada halaman |
| Git & GitHub | Kolaborasi dan pengelolaan kode |

**Catatan:** Proyek menggunakan PHP Native dengan pola MVC secara manual. Penggunaan framework seperti Laravel atau Bootstrap tidak menjadi keharusan dalam rancangan ini.

## 3. Peran Pengguna

SportSpace memiliki dua jenis pengguna:

### A. Customer (Pengguna)

Customer merupakan orang yang ingin mencari dan memesan fasilitas olahraga.

Hak akses:
- Melihat halaman utama SportSpace.
- Melihat daftar lapangan yang tersedia.
- Melihat detail lapangan, harga, dan fasilitas.
- Memilih tanggal dan jam pemesanan.
- Melakukan pemesanan lapangan.
- Melihat riwayat pemesanan.
- Membatalkan pemesanan sesuai aturan aplikasi.

### B. Admin

Admin merupakan pihak yang bertugas mengelola aplikasi dan data lapangan.

Hak akses:
- Login ke halaman admin.
- Melihat dashboard dan ringkasan pemesanan.
- Menambahkan data lapangan.
- Mengubah informasi lapangan.
- Menghapus data lapangan.
- Melihat seluruh data pemesanan.
- Mengubah status pemesanan.

## 4. Fitur Utama Aplikasi

### A. Halaman Customer

| Fitur | Deskripsi |
|---|---|
| Home | Menampilkan informasi dan pengenalan SportSpace. |
| Daftar Lapangan | Menampilkan lapangan yang tersedia untuk dipesan. |
| Detail Lapangan | Menampilkan nama, jenis olahraga, harga, fasilitas, dan deskripsi lapangan. |
| Booking Lapangan | Customer memilih tanggal dan jam untuk melakukan pemesanan. |
| My Booking | Menampilkan daftar dan status pemesanan milik customer. |
| Login & Register | Mengelola akun customer. |

### B. Halaman Admin

| Fitur | Deskripsi |
|---|---|
| Admin Dashboard | Menampilkan ringkasan jumlah lapangan dan pemesanan. |
| Manage Courts | Mengelola data lapangan dengan fitur CRUD. |
| Manage Bookings | Melihat dan mengelola seluruh pemesanan. |
| Update Status | Mengubah status pemesanan, misalnya pending, confirmed, atau cancelled. |

## 5. Alur Penggunaan Aplikasi

### Alur Customer

1. Customer membuka website SportSpace.
2. Customer melihat daftar lapangan yang tersedia.
3. Customer memilih salah satu lapangan.
4. Customer melihat detail dan harga lapangan.
5. Customer login atau melakukan registrasi jika belum memiliki akun.
6. Customer memilih tanggal dan jam bermain.
7. Customer mengirim formulir pemesanan.
8. Sistem memeriksa apakah jadwal tersebut masih tersedia.
9. Jika tersedia, pemesanan disimpan ke database.
10. Customer dapat melihat status pemesanan melalui halaman My Booking.

### Alur Admin

1. Admin membuka halaman login.
2. Admin masuk menggunakan akun admin.
3. Admin diarahkan ke dashboard.
4. Admin dapat menambahkan, mengubah, dan menghapus data lapangan.
5. Admin dapat melihat daftar pemesanan.
6. Admin dapat mengubah status pemesanan.

## 6. Rancangan Database

Database yang digunakan bernama `sportspace_db`.

Rancangan awal menggunakan tiga tabel utama:

### A. Tabel `users`

Menyimpan informasi akun pengguna dan admin.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key |
| name | VARCHAR(100) | Nama pengguna |
| email | VARCHAR(100) | Email akun |
| password | VARCHAR(255) | Password yang sudah di-hash |
| role | ENUM | customer / admin |
| created_at | TIMESTAMP | Waktu pembuatan akun |

### B. Tabel `courts`

Menyimpan informasi fasilitas olahraga.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key |
| name | VARCHAR(100) | Nama lapangan |
| sport_type | VARCHAR(50) | Jenis olahraga |
| description | TEXT | Deskripsi lapangan |
| price_per_hour | DECIMAL(10,2) | Harga per jam |
| facilities | TEXT | Fasilitas yang tersedia |
| image | VARCHAR(255) | Nama/path gambar |
| status | ENUM | available / unavailable |
| created_at | TIMESTAMP | Waktu pembuatan data |

### C. Tabel `bookings`

Menyimpan informasi pemesanan lapangan.

| Field | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key |
| user_id | INT | Foreign Key ke users.id |
| court_id | INT | Foreign Key ke courts.id |
| booking_date | DATE | Tanggal pemesanan |
| start_time | TIME | Jam mulai |
| end_time | TIME | Jam selesai |
| total_price | DECIMAL(10,2) | Total harga |
| status | ENUM | pending / confirmed / cancelled |
| created_at | TIMESTAMP | Waktu pemesanan |

**Relasi database:**
- Satu user dapat memiliki banyak booking.
- Satu court dapat memiliki banyak booking.
- Setiap booking dimiliki oleh satu user dan satu court.

Sistem juga harus memeriksa bentrok jadwal agar satu lapangan tidak bisa dipesan oleh dua customer pada waktu yang sama.

## 7. Konsep Arsitektur MVC

Aplikasi menggunakan pola Model-View-Controller (MVC).

### Model
Bertanggung jawab untuk berinteraksi dengan database.

Contoh:
- `User.php`
- `Court.php`
- `Booking.php`

### View
Bertanggung jawab menampilkan halaman website kepada pengguna.

Contoh:
- `home.php`
- `courts.php`
- `court-detail.php`
- `booking.php`
- `dashboard.php`

### Controller
Bertanggung jawab menerima request, memproses input, melakukan validasi, dan menghubungkan Model dengan View.

Contoh:
- `AuthController.php`
- `CourtController.php`
- `BookingController.php`
- `AdminController.php`

## 8. Rancangan Struktur Folder

```text
sportspace/
│
├── app/
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── CourtController.php
│   │   ├── BookingController.php
│   │   └── AdminController.php
│   │
│   ├── models/
│   │   ├── User.php
│   │   ├── Court.php
│   │   └── Booking.php
│   │
│   ├── repositories/
│   │   ├── UserRepository.php
│   │   ├── CourtRepository.php
│   │   └── BookingRepository.php
│   │
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── customer/
│       └── admin/
│
├── config/
│   └── database.php
│
├── public/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── index.php
│
├── routes/
│   └── web.php
│
├── .gitignore
└── README.md
```

Struktur folder dapat disesuaikan dengan implementasi MVC yang diajarkan di kelas, selama pemisahan Model, View, dan Controller tetap diterapkan.

## 9. Rancangan Route

Contoh route yang direncanakan:

| Method | Route | Fungsi |
|---|---|---|
| GET | `/` | Menampilkan halaman utama |
| GET | `/courts` | Menampilkan daftar lapangan |
| GET | `/courts/{id}` | Menampilkan detail lapangan |
| GET | `/booking` | Menampilkan halaman pemesanan |
| GET | `/my-bookings` | Menampilkan booking customer |
| GET | `/admin` | Menampilkan dashboard admin |
| POST | `/register` | Memproses registrasi |
| POST | `/login` | Memproses login |
| POST | `/booking/store` | Menyimpan pemesanan |
| POST | `/admin/courts/store` | Menambahkan lapangan |
| POST | `/admin/courts/update` | Mengubah data lapangan |
| POST | `/admin/courts/delete` | Menghapus data lapangan |
| POST | `/admin/bookings/update-status` | Mengubah status booking |

Semua input yang diterima harus divalidasi di Controller sebelum diproses lebih lanjut.

## 10. Pembagian Tugas Kelompok

Proyek dikerjakan oleh tiga anggota. Pembagian dilakukan berdasarkan fitur agar setiap anggota memiliki tanggung jawab pengembangan yang jelas.

### Anggota 1 – Authentication & User Management

**Tanggung jawab utama: pengelolaan akun dan autentikasi.**

Fitur yang dikerjakan:
- Halaman register.
- Halaman login.
- Proses registrasi akun.
- Proses login dan logout.
- Password hashing.
- Pengelolaan session.
- Pembatasan akses berdasarkan role customer dan admin.
- User Model dan User Repository.
- Integrasi autentikasi dengan halaman customer dan admin.

File utama:
- `AuthController.php`
- `User.php`
- `UserRepository.php`
- View pada folder `auth/`

### Anggota 2 – Court Management

**Tanggung jawab utama: informasi dan pengelolaan lapangan.**

Fitur yang dikerjakan:
- Halaman utama.
- Halaman daftar lapangan.
- Halaman detail lapangan.
- Menampilkan informasi harga dan fasilitas.
- Menambahkan data lapangan.
- Mengubah data lapangan.
- Menghapus data lapangan.
- Validasi input data lapangan.
- Court Model dan Court Repository.

File utama:
- `CourtController.php`
- `Court.php`
- `CourtRepository.php`
- View pada folder `customer/` dan bagian pengelolaan lapangan di `admin/`

### Anggota 3 – Booking Management

**Tanggung jawab utama: proses pemesanan dan pengelolaan booking.**

Fitur yang dikerjakan:
- Halaman formulir booking.
- Proses penyimpanan booking.
- Pemilihan tanggal dan jam.
- Validasi jadwal pemesanan.
- Pemeriksaan bentrok jadwal.
- Perhitungan total harga.
- Halaman My Booking.
- Pengelolaan status booking.
- Booking Model dan Booking Repository.

File utama:
- `BookingController.php`
- `Booking.php`
- `BookingRepository.php`
- View pada folder `customer/` dan bagian booking di `admin/`

### Tugas Bersama

Beberapa pekerjaan perlu dilakukan dan dipahami oleh seluruh anggota:

- Menentukan desain dan tampilan website.
- Menyusun struktur awal proyek MVC.
- Menyiapkan database MySQL.
- Menentukan format route dan cara pemanggilan Controller.
- Mengintegrasikan seluruh fitur.
- Melakukan testing aplikasi.
- Memperbaiki bug hasil integrasi.
- Menyiapkan dokumentasi dan presentasi/demo proyek.

**Catatan pembagian:** Pembagian di atas adalah pembagian awal. Ketiga anggota tetap perlu saling membantu ketika integrasi, testing, atau ketika ada fitur yang mengalami kendala. Setiap anggota juga harus memiliki kontribusi commit yang jelas.

## 11. Aturan Kolaborasi Git & GitHub

Proyek menggunakan satu repository GitHub yang dikerjakan bersama.

### Branch

Setiap anggota mengerjakan fitur melalui branch masing-masing.

Contoh:
- `feature/auth-user`
- `feature/court-management`
- `feature/booking-management`

### Alur Kerja

1. Clone repository.
2. Ambil perubahan terbaru dari branch utama.
3. Buat atau pindah ke branch fitur masing-masing.
4. Kerjakan fitur yang menjadi tanggung jawab.
5. Commit perubahan secara berkala.
6. Push branch ke GitHub.
7. Buat Pull Request (PR).
8. Anggota lain melakukan review kode.
9. Perbaiki jika ada masukan.
10. Merge ke branch utama setelah disetujui.

### Contoh Commit

```bash
git add .
git commit -m "feat: add user login"
git push origin feature/auth-user
```

Contoh pesan commit:
- `feat: add court listing page`
- `feat: implement booking validation`
- `fix: prevent overlapping booking schedule`
- `style: improve customer dashboard`
- `docs: update project readme`

## 12. Batasan Proyek (Project Scope)

Agar proyek tetap realistis dan bisa diselesaikan sesuai waktu pengerjaan, fitur utama yang akan diprioritaskan adalah:

**Fitur wajib dalam rancangan aplikasi:**
- Login dan register.
- Role customer dan admin.
- Daftar serta detail lapangan.
- CRUD data lapangan.
- Pemesanan lapangan.
- Validasi jadwal.
- Riwayat pemesanan.
- Pengelolaan status booking oleh admin.

**Fitur yang tidak menjadi prioritas:**
- Pembayaran online melalui payment gateway.
- Integrasi aplikasi mobile.
- Notifikasi WhatsApp otomatis.
- Integrasi Google Maps.
- Sistem membership atau loyalty point.

Pembayaran online tidak termasuk dalam ruang lingkup awal. Pemesanan cukup dicatat ke database dan statusnya dikelola melalui aplikasi.

## 13. Target Hasil Akhir

Hasil akhir proyek berupa aplikasi web SportSpace yang dapat dijalankan melalui browser dan memiliki:

- Tampilan website yang dapat digunakan customer dan admin.
- Backend PHP dengan arsitektur MVC.
- Database MySQL yang terhubung menggunakan PDO.
- Fitur CRUD yang berfungsi.
- Minimal dua GET route dan dua POST route.
- Validasi input pada Controller.
- Repository GitHub dengan branch, commit, Pull Request, dan review dari anggota kelompok.

---

**SportSpace – Find Your Court, Book Your Game.**