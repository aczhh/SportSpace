# SportSpace – Sports Facility Booking

**Find Your Court, Book Your Game.**

## About the Project

SportSpace merupakan aplikasi berbasis web yang dikembangkan untuk memudahkan pengguna dalam mencari informasi dan melakukan pemesanan lapangan olahraga secara online.

Aplikasi ini menyediakan informasi mengenai berbagai jenis lapangan olahraga, seperti futsal, badminton, dan basket. Pengguna dapat melihat detail lapangan, melakukan pemesanan, serta memantau riwayat booking.

SportSpace dikembangkan sebagai proyek kelompok mata kuliah Pemrograman Web dengan menerapkan arsitektur Model-View-Controller (MVC).

## Features

### Customer
- Register dan login akun.
- Melihat daftar lapangan olahraga.
- Melihat detail dan informasi harga lapangan.
- Melakukan pemesanan lapangan.
- Melihat riwayat pemesanan.
- Logout.

### Admin
- Login sebagai admin.
- Melihat dashboard.
- Mengelola data lapangan (Create, Read, Update, Delete).
- Melihat seluruh data pemesanan.
- Mengubah status pemesanan.
- Logout.

## Tech Stack

- **Backend:** PHP Native
- **Database:** MySQL
- **Database Connection:** PDO
- **Frontend:** HTML, CSS, JavaScript
- **Version Control:** Git & GitHub

## Architecture

SportSpace menggunakan arsitektur Model-View-Controller (MVC).

- **Model:** Mengelola data dan komunikasi dengan database.
- **View:** Menampilkan antarmuka aplikasi kepada pengguna.
- **Controller:** Mengelola request, validasi input, dan alur aplikasi.

## Database

Aplikasi menggunakan database MySQL dengan tiga tabel utama:

| Table | Description |
|---|---|
| `users` | Menyimpan data akun customer dan admin. |
| `courts` | Menyimpan informasi lapangan olahraga. |
| `bookings` | Menyimpan data pemesanan lapangan. |

## Installation

1. Clone repository ini:

   ```bash
   git clone <repository-url>
   ```

2. Pindahkan folder proyek ke direktori `htdocs` jika menggunakan XAMPP.

3. Jalankan Apache dan MySQL.

4. Buat database dengan nama `sportspace_db`.

5. Import file database yang tersedia pada folder `database/`.

6. Sesuaikan konfigurasi koneksi database.

7. Buka aplikasi melalui browser menggunakan alamat lokal yang telah dikonfigurasi.

## Demo Account

**Admin Account**

Informasi akun admin disediakan untuk keperluan pengujian aplikasi.

- Email: Akan ditambahkan.
- Password: Akan ditambahkan.

Customer dapat membuat akun melalui halaman Register.

## Contributors

- Azzah Rafidah (202410370110437)
- Faizza Divana (202410370110422)
- Nadia Setiana (202410370110403)

---

**SportSpace – Find Your Court, Book Your Game.**
