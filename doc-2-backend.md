# Dokumentasi Pembuatan CMS Komunitas (Tahap 2 - Autentikasi & Antarmuka Admin)

Dokumen ini melengkapi `doc-1-struktur.md` dengan merangkum penambahan fitur autentikasi, penyelesaian masalah (troubleshooting) migrasi, serta pembangunan kerangka antarmuka pengguna (UI) untuk panel Admin beserta contoh operasi CRUD.

## 1. Modul Autentikasi Admin

Telah dibangun sistem otorisasi dan autentikasi khusus admin untuk mengamankan akses ke backend.
*   **Controller (`AuthController.php`):**
    *   `showLoginForm()`: Menampilkan view login (melakukan proteksi redirect jika user sudah masuk).
    *   `authenticate()`: Menggunakan `Auth::attempt()` yang divalidasi terhadap email, password, dan field `role` = 'admin'. Session akan diamankan (*regenerate*).
    *   `logout()`: Mengakhiri sesi `Auth::logout()` dan mengatur ulang CSRF Token untuk mencegah *session fixation*.
*   **Routing:** Menambahkan _endpoint_ `/login` (GET/POST) dan `/logout` (POST) pada `routes/web.php`.
*   **View Login (`auth/login.blade.php`):** Antarmuka sederhana yang terintegrasi dengan **Tailwind CSS**. Mengandung elemen blok error global jika email/sandi tidak sesuai dengan pangkalan data.

---

## 2. Pemecahan Masalah & Manajemen Seeder

*   **Penyelesaian Skema Database:** Dilakukan eksekusi `php artisan migrate:fresh` untuk me-reset struktur tabel guna mengatasi error _"Unknown column 'role'"_. Hal ini memastikan file `0001_01_01_000000_create_users_table.php` (yang kita modifikasi di tahap 1) benar-benar tereksekusi ke dalam MySQL.
*   **`AdminSeeder` Khusus:** Diciptakan file `database/seeders/AdminSeeder.php` sebagai cara cepat merender akun admin via *Command Line Interface* (CLI). Administrator sistem kini dapat melakukan perintah `php artisan db:seed --class=AdminSeeder` di terminal untuk mendapatkan akun secara terisolasi tanpa mempengaruhi data dummy tabel lain.

---

## 3. Pembangunan Layout Admin (Backend UI)

Dirancang menggunakan integrasi CDN **Tailwind CSS** untuk mempercepat proses *styling*.

*   **Master Layout (`layouts/admin.blade.php`):**
    *   **Sidebar Navigasi Kiri:** Bersifat *fixed* (tetap), menampung hierarki menu utama (Dashboard, Struktur Anggota, Program Kerja, dll). Diperlengkapi dengan fitur *highlight route aktif* (`request()->routeIs()`) dan tombol *Logout* merah terpadu di bagian bawah.
    *   **Content Area Kanan:** Bersifat dinamis yang dipasok oleh `@yield('content')`.
    *   **Penangkap Flash Session Global:** Kode pintar pada layout disisipkan secara *built-in* untuk secara otomatis menangkap kembalian variabel `session('success')`, `session('error')`, dan validasi sistem bawaan `$errors->any()`.
*   **Dashboard Utama (`admin/dashboard.blade.php`):**
    *   Menampilkan blok komponen statistik langsung dari model Eloquent (contoh: `\App\Models\News::count()`).
    *   Berperan sebagai laman rujukan (landing page) awal ketika Administrator masuk.

---

## 4. Antarmuka CRUD Berita (Proof of Concept)

Ketiga file View (*Blade*) berikut ini ditambahkan ke direktori `resources/views/admin/news/` yang langsung ditautkan (*extends*) ke `layouts.admin`:

| File View | Deskripsi & Fungsionalitas |
| :--- | :--- |
| `index.blade.php` | Menampilkan tabel (*grid list*) berita. Terdiri dari *Title*, *Author*, Label *Status* warna-warni (hijau untuk *published*, abu-abu untuk *draft*), *Date*, dan menu aksi (Edit, Hapus) menggunakan konfirmasi *prompt alert*. Mendukung *pagination*. |
| `create.blade.php` | Form penambahan berita yang mengandung proteksi `enctype="multipart/form-data"`. Termasuk properti `old()` agar isi input tak hilang jika validasi gagal. Peringatan pesan *error* diletakkan merapat di bawah setiap field secara independen. |
| `edit.blade.php` | Form pembaruan berita dengan arahan HTTP `@method('PUT')`. Form sudah ter- *pre-populate* dengan data berita (seperti `$news->content`). Menyediakan fitur cuplikan/pratinjau (*preview*) thumbnail lama sebelum diganti dengan thumbnail baru. |

### Langkah Berikutnya 
Dengan usainya integrasi di tahap 2 ini, CMS telah memiliki pondasi menyeluruh baik dari *Frontend* maupun *Backend*. Modul CRUD lain seperti `members`, `educations`, `work_programs` dapat diimplementasikan dengan menduplikasi pola kode dari `NewsController` dan `admin/news/*.blade.php`.
