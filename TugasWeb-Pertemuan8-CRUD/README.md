# Tugas Rutin 8 — CRUD Inventaris

## 1. Deskripsi

Aplikasi web sederhana untuk mengelola data inventaris barang, lengkap dengan
kategori dan lokasi penyimpanan. Aplikasi ini dibuat memenuhi Tugas Rutin 8
mata kuliah Pemrograman Web, dengan fokus pada implementasi CRUD, relasi
database (JOIN), keamanan query (prepared statement), dan normalisasi
database sampai 3NF.

## 2. Teknologi yang Digunakan

- PHP Native (tanpa framework)
- MySQL
- PDO (PHP Data Objects) untuk koneksi & query database
- HTML, CSS
- Bootstrap 5 (melalui CDN)

## 3. Struktur Folder

```
TugasWeb-Pertemuan8-CRUD/
│
├── config/
│   └── database.php          # Konfigurasi koneksi PDO + BASE_URL
│
├── public/
│   ├── includes/
│   │   ├── header.php        # Navbar + alert flash message
│   │   └── footer.php
│   ├── index.php             # Dashboard
│   ├── inventories/
│   │   ├── index.php         # Daftar inventaris (JOIN kategori & lokasi)
│   │   ├── create.php        # Tambah inventaris
│   │   ├── edit.php          # Edit inventaris
│   │   └── delete.php        # Hapus inventaris
│   ├── categories/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── edit.php
│   │   └── delete.php
│   └── locations/
│       ├── index.php
│       ├── create.php
│       ├── edit.php
│       └── delete.php
│
├── assets/
│   └── css/
│       └── style.css
│
├── schema.sql
└── README.md
```

## 4. ERD Sederhana

```
categories (category_id PK, category_name)
      |
      | 1 : N
      v
inventories (inventory_id PK, item_name, quantity,
             category_id FK, location_id FK, created_at)
      ^
      | N : 1
      |
locations (location_id PK, location_name)
```

Penjelasan relasi:
- Satu kategori bisa dimiliki oleh banyak inventaris (`categories` 1 — N `inventories`).
- Satu lokasi bisa dimiliki oleh banyak inventaris (`locations` 1 — N `inventories`).
- Tabel `inventories` menyimpan `category_id` dan `location_id` sebagai foreign key,
  bukan menduplikasi nama kategori/lokasi, sehingga database ternormalisasi sampai 3NF.

## 5. Cara Menjalankan Project (XAMPP)

1. Copy folder `TugasWeb-Pertemuan8-CRUD` ke dalam folder `htdocs` XAMPP Anda,
   misalnya: `C:\xampp\htdocs\TugasWeb-Pertemuan8-CRUD`.
2. Jalankan **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Ikuti langkah *Membuat Database* dan *Import schema.sql* di bawah.
4. Buka browser dan akses:

   ```
   http://localhost/TugasWeb-Pertemuan8-CRUD/public/index.php
   ```

## 6. Cara Membuat Database

1. Buka **phpMyAdmin** melalui `http://localhost/phpmyadmin`.
2. Anda tidak perlu membuat database secara manual — `schema.sql` sudah
   mengandung perintah `CREATE DATABASE IF NOT EXISTS inventaris_db`.

## 7. Cara Import schema.sql melalui phpMyAdmin

1. Buka phpMyAdmin.
2. Klik menu **Import** di bagian atas.
3. Klik **Choose File**, lalu pilih file `schema.sql` dari folder project ini.
4. Klik tombol **Go / Import** di bagian bawah halaman.
5. Setelah berhasil, database `inventaris_db` beserta tabel `categories`,
   `locations`, `inventories`, dan data dummy akan otomatis dibuat.

## 8. Cara Mengatur Koneksi Database

Buka file `config/database.php`, sesuaikan bagian berikut jika kredensial
MySQL Anda berbeda dari default XAMPP:

```php
$host    = 'localhost';
$dbname  = 'inventaris_db';
$dbuser  = 'root';
$dbpass  = '';
```

Jika nama folder project Anda berbeda dari `TugasWeb-Pertemuan8-CRUD`,
sesuaikan juga konstanta berikut pada file yang sama:

```php
define('BASE_URL', '/TugasWeb-Pertemuan8-CRUD/public/');
```

## 9. Screenshot Aplikasi

> Tambahkan screenshot aplikasi Anda pada bagian di bawah ini setelah project berhasil dijalankan.

- Dashboard:
  [Tambahkan screenshot halaman dashboard di sini]

- Daftar Inventaris:
  [Tambahkan screenshot halaman daftar inventaris di sini]

- Form Tambah/Edit Inventaris:
  [Tambahkan screenshot form tambah/edit inventaris di sini]

- Daftar Kategori:
  [Tambahkan screenshot halaman daftar kategori di sini]

- Daftar Lokasi:
  [Tambahkan screenshot halaman daftar lokasi di sini]

## 10. Fitur yang Tersedia

- Dashboard menampilkan jumlah total inventaris, kategori, dan lokasi
- CRUD Inventaris lengkap (Create, Read, Update, Delete)
- Daftar inventaris menampilkan nama kategori & lokasi menggunakan JOIN
- CRUD Kategori (Create, Read, Update, Delete)
- CRUD Lokasi (Create, Read, Update, Delete)
- Validasi input server-side (field wajib, quantity harus angka)
- Konfirmasi sebelum menghapus data
- Prepared statement (PDO) pada seluruh query yang melibatkan input user
- `htmlspecialchars()` pada seluruh output data ke halaman
- Error handling dengan try/catch PDO tanpa membocorkan detail teknis database
- Foreign key dengan `ON DELETE RESTRICT` agar kategori/lokasi yang masih
  dipakai tidak bisa dihapus sembarangan
