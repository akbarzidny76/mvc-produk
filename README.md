# MVC PHP Native - Data Produk

Aplikasi CRUD untuk mengelola data produk dan kategori dengan pola Model-View-Controller pada PHP Native.

## Kebutuhan
- PHP 8.1 atau lebih baru
- MySQL/MariaDB
- Web server lokal seperti XAMPP atau Laragon
- Git

## Instalasi
1. Salin project ke folder web server (`htdocs` pada XAMPP, `www` pada Laragon).
2. Import `database/toko.sql` melalui phpMyAdmin atau `mysql -u root -p < database/toko.sql`.
3. Sesuaikan koneksi pada `config/database.php`.
4. Buka `http://localhost/mvc-produk/public/index.php`.

## Struktur MVC
- `app/models/` : akses dan operasi data (Kategori, Produk).
- `app/controllers/` : alur request, validasi, pemanggilan Model/View.
- `app/views/` : tampilan HTML (termasuk layout header/footer).
- `app/helpers/` : fungsi bantu (escape, flash message, redirect).
- `config/` : konfigurasi koneksi database.
- `database/` : skema dan data awal SQL.
- `public/` : entry point dan router.

## Fitur
- CRUD produk (kode, nama, kategori, harga, stok, deskripsi, status)
- CRUD kategori; kategori yang masih dipakai produk tidak dapat dihapus
- Validasi input, prepared statement, escaping output, dan pesan sukses/gagal
- Penanda stok rendah (5 atau kurang) pada daftar produk

## Histori Git
Gunakan `git log --oneline --graph --decorate` untuk melihat tahapan pengembangan.