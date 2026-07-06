# Dokumentasi Pembuatan CMS Komunitas (Tahap 10 - Block-Based Page Builder)

Dokumen ini merangkum proses evolusi sistem manajemen halaman statis menjadi sistem **Block-Based Page Builder** yang dinamis. Fitur ini dirancang untuk memberikan fleksibilitas tanpa batas bagi Administrator dalam menyusun tata letak halaman yang kaya (seperti laman "Tentang Kami", "Sejarah", atau "Visi Misi") tanpa bergantung pada WYSIWYG tunggal.

## 1. Skema Database & Persiapan Model

Untuk menampung arsitektur baru, sebuah entitas baru `Page` telah didirikan:

*   **Migrasi**: Menambahkan tabel `pages` dengan kolom penting:
    *   `title` (string): Judul halaman.
    *   `slug` (string, unique): Penanda URL unik (otomatis digenerate dari `title` jika dibiarkan kosong).
    *   `content_blocks` (json, nullable): Inti dari fitur ini. Menyimpan seluruh susunan elemen halaman dalam format array JSON.
*   **Model (`App\Models\Page`)**:
    *   Ditambahkan *Mass Assignment Protection* pada `$fillable`.
    *   Sistem *casting* pintar ditambahkan `protected $casts = ['content_blocks' => 'array'];` untuk memerintahkan Laravel mengonversi format JSON mentah dari *database* menjadi array PHP asli (dan sebaliknya) secara otomatis.

---

## 2. Pembangunan Antarmuka Admin Dinamis (Alpine.js)

Lantaran manajemen form berformat *array* bisa menjadi malapetaka jika dilakukan secara manual di backend, antarmuka `admin/pages/create.blade.php` (dan nantinya `edit.blade.php`) diotomasasi penuh menggunakan pustaka **Alpine.js**.

*   **State Management**: Menggunakan `x-data="pageBuilder()"` yang mengelola sebuah variabel array `blocks: []`.
*   **Fungsi Penambahan**: Tombol-tombol di layar secara instan menyuntikkan objek kosong ke dalam array, contohnya tipe Judul: `{ id: Date.now(), type: 'judul', content: '' }`.
*   **Pengikatan Data (Data Binding)**: 
    *   Menggunakan direktif `<template x-for="block in blocks">`.
    *   Secara cerdik, setiap kotak input mengikatkan namanya ke *nested array* PHP via: `:name="'content_blocks[' + index + '][content]'"`.
*   **Tipe Komponen**:
    1.  `judul`: Meminta input teks *single-line*.
    2.  `teks`: Meminta input teks panjang melalui *textarea*.
    3.  `gambar`: Meminta input file tipe *image*.
    4.  `video_youtube`: Meminta ID Video murni dari URL YouTube.
    5.  `iframe`: Menerima sintaks HTML utuh.
    6.  `tabel`: Menginstruksikan Admin untuk mencantumkan data CSV.

---

## 3. Eksekusi Backend (Pengontrol & Penanganan File)

Pemrosesan logika diserahkan pada `Admin\PageController`:

*   **Validasi Aman**: Semua masukan divalidasi. `$request->validate(['content_blocks' => 'nullable|array'])` memastikan sistem tidak tertipu oleh injeksi data palsu.
*   **Logika Penanganan File Gambar (Resolusi Fatal Error)**: 
    Karena struktur data dikirim berlapis (*multidimensional array*), sistem `store()` konvensional milik Laravel gagal mengeksekusi gambar. Oleh karenanya, sebuah iterasi manual dibangun:
    *   Pada fungsi `store`: Melakukan *looping* untuk mendeteksi block `'gambar'`. Jika `hasFile()` bernilai *true*, file diunggah ke `storage/app/public/pages` dan *string object* diubah menjadi *path string*.
    *   Pada fungsi `update`: Sama dengan `store`, tetapi ditambah kecerdasan komparasi. Jika saat pembaruan Administrator tidak menautkan foto baru, algoritma akan mengambil *path string* dari *Database* lama dan mengkloningnya, memastikan gambar yang ada tidak tertimpa dengan status kosong/menghilang.

---

## 4. Perenderan Publik & Routing Dinamis

Tahap akhir adalah mengolah JSON yang tersimpan agar tampil memukau di sisi penjelajah web.

*   **Routing Dinamis (`routes/web.php`)**:
    Menambahkan `Route::get('/{slug}', [FrontEndController::class, 'showPage'])` dan meletakkannya di **baris paling bawah** daftar *route* publik. Ini penting agar Laravel memprioritaskan pemindaian *route* tetap (seperti `/gabung` atau `/login`) sebelum terjun untuk mencari *slug* sembarang.
*   **Konstruksi View (`frontend/page.blade.php`)**:
    Melakukan `foreach` ke dalam `$page->content_blocks` dan menggunakan arsitektur struktur `@switch($block['type'])`:
    *   `@case('judul')` -> `<h2>` (Tailwind styling khusus).
    *   `@case('teks')` -> `<p>`.
    *   `@case('gambar')` -> `<img src="{{ asset(...) }}">`.
    *   `@case('video_youtube')` -> Membungkus ID video ke dalam URL Embed `<iframe>` bawaan YouTube `https://www.youtube.com/embed/`.
    *   `@case('iframe')` -> Dicetak langsung secara tak bersanitasi (*unescaped*) menggunakan `{!! !!}`.
    *   `@case('tabel')` -> Sistem cerdas mem- *parsing* (membedah) konten CSV berbekal perintah PHP `explode()`. Baris dipecah dengan Enter (`\n`), sedangkan sel dipecah dengan koma (`,`). Baris 1 otomatis dijadikan `<thead>` & `<th>`, sementara baris sisa dicetak rapi dan interaktif (hover color) pada `<tbody>` & `<td>`.

Sistem *Page Builder* berarsitektur dinamis ini membuka pintu bagi pengelola situs untuk mengekspresikan kreativitas tata letak di luar limitasi teks semata.
