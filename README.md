
 **SIBORU – Sistem Booking Ruangan**

SIBORU adalah aplikasi pemesanan ruangan berbasis web yang digunakan untuk mempermudah proses booking ruangan, verifikasi oleh admin/panitia, serta menampilkan bukti booking dan rating ruangan.

---

 **Anggota Kelompok**

**KELOMPOK 5**

* Diva Angeliana (701230051
* khaila aura nurhadi (701230029)
* putri yani anjali (701230052)

---

  **Fitur Utama**

 **1. Autentikasi & Keamanan**

* Login dan Logout
* Role-based access (Admin / Panitia )
* Session secure
* Validasi akses halaman
* Password hashing otomatis (bcrypt)

 **2. Booking Ruangan**

* User dapat melakukan pemesanan ruangan
* Sistem otomatis mencegah bentrok jadwal
* Tampilan kalender ketersediaan ruangan
* Mengunggah detail kegiatan

 **3. Manajemen Booking (Admin)**

* Menyetujui / Menolak booking
* Menambah alasan penolakan
* Lihat semua daftar booking realtime

 **4. Notifikasi Realtime**

* Ikon notifikasi 🔔 di dashboard
* Notifikasi berubah otomatis saat booking disetujui/ditolak
* Halaman khusus untuk melihat daftar notifikasi

 **5. Riwayat Booking**

* User melihat seluruh riwayat pemesanan
* Status: diproses, disetujui, ditolak
* Akses bukti booking setelah disetujui

 **6. Bukti Booking**

* Halaman bukti booking lengkap
* Informasi ruangan, kegiatan, tanggal dan jam
* Bisa dicetak (print view)

 **7. Rating Ruangan**

* User memberikan rating setelah booking selesai
* Rating (1–5) dan komentar
* Terkait ruangan yang digunakan

---

 🗂️ **Struktur Folder**

```
siboru/
│── config/
│   ├── database.php      # Koneksi database
│   ├── session.php       # Helper session & auth
│
│── pages/
│   ├── dashboard.php     # Dashboard utama user
│   ├── admin.php         # Dashboard admin/panitia
│   ├── booking.php       # Form booking
│   ├── panitia.php       # Halaman persetujuan booking
│   ├── history.php       # Riwayat booking
│   ├── bukti_booking.php # Bukti booking
│   ├── rating.php        # Rating ruangan
│   ├── notifikasi.php    # Daftar notifikasi
│
│── process/
│   ├── booking_store.php # Proses simpan booking
│   ├── approve.php       # Persetujuan oleh admin
│   ├── reject.php        # Penolakan booking
│
│── public/
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── style.css
│
└── README.md
```

---

 🔧 **Cara Instalasi**

 **Prasyarat**

* PHP 7.4+
* MySQL 5.7+
* Apache / Nginx
* phpMyAdmin (opsional)

---

 🛠️ **Langkah Instalasi**

 **1. Clone Repository**

```bash
git clone https://github.com/username/siboru.git
cd siboru

 **2. Import Database**

Buat database `siboru_db` di MySQL.

Lalu buat tabel-tabel berikut:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    name VARCHAR(100),
    type ENUM('admin', 'panitia', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ruangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100)
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    ruangan_id INT,
    tanggal DATE,
    jam_mulai TIME,
    jam_selesai TIME,
    kegiatan TEXT,
    status ENUM('diproses','disetujui','ditolak') DEFAULT 'diproses',
    alasan_penolakan TEXT NULL,
    notif_panitia INT DEFAULT 0,
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruangan_id INT,
    user_id INT,
    rating INT,
    komentar TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

🔑 **User Default**

Setelah instalasi, kamu bisa login menggunakan akun berikut:

### **Admin**

```
Email    : admin@siboru.com
Password : admin123
Role     : Admin
```

**Panitia**

```
Email    : panitia@siboru.com
Password : panitia123
Role     : Panitia
```

> Sistem akan otomatis meng-hash password saat pembuatan user.

---

🖥️ Panduan Penggunaan

1. Login

 Masukkan email & password
 Sistem mengarahkan sesuai role (Admin / Panitia)
  
2. User – Booking Ruangan

 Klik *Booking Ruangan*
 Pilih tanggal dan jam
 Isi kegiatan
 Simpan

3. Panitia – Verifikasi Booking

 Lihat daftar booking
 Klik Setujui / Tolak
 Isi alasan jika ditolak

4. Notifikasi

 Muncul di ikon 🔔
 Tidak muncul popup berulang
 Semua perubahan admin langsung tampil ke panitia

5. Cetak Bukti Booking

 Hanya muncul bila status: **disetujui**

6. Rating Ruangan

 Muncul di riwayat untuk booking yang selesai
 Rating + Komentar

---
🛠️ Teknologi yang Digunakan

* PHP Native
* MySQL
* HTML + CSS
* JavaScript
* AJAX (untuk notifikasi realtime)
* Bootstrap (opsional)

---

Troubleshooting

🔹 Tidak bisa login

 Cek koneksi database
 Pastikan password benar
 Pastikan session aktif

🔹 Booking bentrok

 Sistem mencegah booking di jam yang sama
 Cek tabel booking untuk duplikasi

🔹Notifikasi tidak muncul

 Pastikan `notif_panitia` berubah 0 → 1 saat dibaca
 Cek file `cek_notifikasi.php` bila menggunakan AJAX

---

📝Lisensi

MIT License

