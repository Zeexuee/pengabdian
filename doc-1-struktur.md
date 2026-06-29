# Dokumentasi Pembuatan CMS Komunitas (Tahap 1 - Struktur & Arsitektur Dasar)

Dokumen ini berisi rekapitulasi semua fitur, struktur database, routing, dan arsitektur yang telah dibangun pada tahap inisialisasi CMS Website Komunitas.

## 1. Database & Eloquent Models

Telah dibuat 7 entitas utama dengan relasi, validasi *fillable*, dan tipe data kolom yang ketat.

| Entitas / Model | Tabel | Deskripsi | Atribut Khusus / Relasi |
| :--- | :--- | :--- | :--- |
| **User** | `users` | Akun administrator sistem. | Ditambahkan enum `role` ('admin', 'user'). |
| **Member** | `members` | Profil dan struktur kepengurusan. | Menggunakan kolom `order` untuk urutan struktur. |
| **WorkProgram** | `work_programs` | Daftar program kerja komunitas. | Status enum: `planned`, `ongoing`, `completed`. |
| **Education** | `educations` | Konten edukasi / artikel panjang. | Menggunakan `slug` dan boolean `is_published`. |
| **News** | `news` | Modul berita/pengumuman terbaru. | Berelasi ke `users` melalui `author_id`. Status enum: `draft`, `published`, `archived`. |
| **Contact** | `contacts` | Pesan/masukan dari pengunjung web. | Menyertakan boolean `is_read`. |
| **JoinRequest** | `join_requests`| Permintaan pendaftaran calon anggota. | Status enum: `pending`, `approved`, `rejected`. |

> **Catatan Keamanan:** Semua model menggunakan PHP 8+ attributes `#[Fillable([...])]` untuk membatasi properti yang dapat diisi secara massal (Mass Assignment Protection).

---

## 2. Keamanan & Autentikasi

*   **Middleware `IsAdmin`:** Sebuah custom middleware (`app/Http/Middleware/IsAdmin.php`) dibuat untuk memblokir akses ke area backend bagi siapapun yang belum login atau tidak memiliki `role` == 'admin'. Middleware ini didaftarkan sebagai alias `is_admin` pada `bootstrap/app.php`.
*   **Database Seeder:** Menambahkan `DatabaseSeeder` default untuk menghasilkan satu akun super-admin secara otomatis agar pengembang bisa login. Kredensial default:
    *   **Email:** `admin@admin.com`
    *   **Password:** `password`

---

## 3. Sistem Routing (`routes/web.php`)

Sistem routing dibagi menjadi dua ranah utama: Publik (Frontend) dan Admin (Backend).

### Area Publik (Tanpa Middleware)
Di-handle oleh `FrontEndController`:
*   `GET /` → Menampilkan Beranda
*   `GET /struktur-anggota` → Menampilkan pengurus
*   `GET /program-kerja` → Menampilkan program
*   `GET /edukasi` → Menampilkan konten edukasi
*   `GET /berita` → Menampilkan berita
*   `GET /kontak` & `POST /kontak` → Form dan aksi kirim pesan
*   `GET /gabung` & `POST /gabung` → Form dan aksi pendaftaran

### Area Admin (Middleware: `auth`, `is_admin`)
Menggunakan URL Prefix `/admin`:
*   `Route::resource` penuh untuk: `/members`, `/work-programs`, `/educations`, `/news`.
*   Routing kustom (Index, Show, Update Status, Destroy) untuk `/contacts` dan `/join-requests`.

---

## 4. Struktur Controller

### `Admin\NewsController` (Contoh Backend)
Mengimplementasikan fungsi CRUD:
*   Penerapan validasi Form Request pada `store()` dan `update()`.
*   Pembuatan `slug` yang otomatis di-*generate* berdasarkan `title` dan UNIX time.
*   Logika upload thumbnail/gambar yang tersimpan di direktori `storage/app/public/news`.
*   Menyematkan ID penulis (`author_id`) secara otomatis mengambil ID user yang terautentikasi.

### `FrontEndController` (Sisi Publik)
Berfungsi menarik data untuk halaman depan:
*   Membatasi pengambilan data berdasarkan status (contoh: berita diambil jika status `published`).
*   Mengelola submission POST form dari *Contact* dan *JoinRequest*, menerapkan validasi, kemudian mengarahkan (*redirect*) kembali (*back*) dengan pesan sukses global.

---

## 5. View (Tampilan) & Arsitektur Frontend

Struktur folder `resources/views` dirombak dan diorganisasi ulang untuk pemisahan peran secara modular:

```text
resources/views/
├── layouts/
│   ├── app.blade.php      <-- Template Master Publik
│   └── admin.blade.php    <-- Template Master Admin (Belum Dibuat)
├── frontend/
│   ├── home.blade.php
│   ├── news.blade.php     <-- Dibuat beserta loop dan pagination data berita
│   ├── ...                <-- (View lainnya)
└── admin/
    ├── news/
    ├── members/
    ├── ...                <-- (View CRUD admin)
```

**Fitur pada `layouts/app.blade.php`:**
*   Global header/navigation menu.
*   Global Flash Session Alert (digunakan untuk menampilkan `session('success')` ketika pengguna sukses mengirim form masukan).
*   Slot `@yield('content')` untuk disuntik dari berbagai file halaman frontend (seperti `news.blade.php`).
