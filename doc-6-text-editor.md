# Dokumentasi Pembuatan CMS Komunitas (Tahap 6 - Integrasi Rich Text Editor)

Dokumen ini merangkum proses integrasi **CKEditor 5 (Classic Editor)** ke dalam CMS, yang memungkinkan Administrator untuk memformat teks konten secara leluasa (*Rich Text*), serta penyesuaian pada sisi *Frontend* agar dapat merender format HTML dengan aman dan tepat.

## 1. Konfigurasi Master Layout Admin (`layouts/admin.blade.php`)

Sebagai langkah fondasi, kita memastikan skrip *editor* tersedia secara global pada area Admin tanpa harus memuat ulang *library* di setiap baris kode:
*   Pustaka CKEditor 5 disuntikkan secara dinamis melalui titik akhir CDN (`https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js`).
*   Skrip ini diletakkan persis di atas tag penutup `</body>` demi menjaga kecepatan muatan elemen DOM utama (struktur HTML).
*   Sebuah *slot* dinamis `@stack('scripts')` didirikan tepat di bawahnya. Area ini berperan sebagai penadah skrip spesifik dari *Views* turunan.

## 2. Implementasi Editor pada Modul Konten Panjang

Modul yang membutuhkan format penulisan terperinci, yakni **Berita** (`admin/news`) dan **Edukasi** (`admin/educations`), telah dimutakhirkan:
*   **Perubahan Elemen Input:** Pada *View* `create.blade.php` maupun `edit.blade.php`, atribut pengenal unik ditiupkan ke dalam elemen input textarea utama (`id="content_editor"`).
*   **Inisialisasi JavaScript:** Memanfaatkan direktif `@push('scripts')`, setiap kali halaman formulir (Berita/Edukasi) dirender, *Browser* akan memanggil kode instalasi CKEditor:
    ```javascript
    ClassicEditor.create(document.querySelector('#content_editor')).catch(error => { console.error(error); });
    ```
    Ini serta merta menyulap kotak teks biasa menjadi *Rich Text Editor* interaktif.

## 3. Kompatibilitas Penayangan di Area Frontend

Lantaran data yang dikirimkan oleh CKEditor kini mengandung *tag-tag* HTML utuh (seperti `<strong>`, `<em>`, `<ul>`), sistem perenderan publik (*Frontend*) wajib dijinakkan agar tidak mencetak elemen HTML mentah di layar:
*   **Pencegahan HTML Escaping:** Pada *View* daftar list konten (seperti `frontend/berita.blade.php`, `frontend/educations.blade.php`, `frontend/home.blade.php`), sintaks pelemparan variabel dari Laravel yang sebelumnya ketat (`{{ $data }}`) telah diganti ke mode *Raw / Unescaped* (`{!! $data !!}`).
*   **Penyelamatan Layout Berbasis Card:** Jika tag HTML terpotong setengah jalan oleh utilitas pembatas teks (misal `<p>Teks...` terpotong sebelum penutup `</p>`), hal ini dapat membuat kerangka HTML rusak parah. Oleh sebab itu, sebelum dipotong dengan `Str::limit()`, data konten terlebih dulu dilucuti dari seluruh *tag* HTML dengan memanggil fungsi bawaan `strip_tags($content)`.
*   **Contoh Eksekusi Aman:**
    ```php
    {!! Str::limit(strip_tags($item->content), 120) !!}
    ```

## Status Sistem Saat Ini
CMS kini telah sepenuhnya mampu melayani publikasi yang kaya format (paragraf, gaya teks, dll.). Data dapat diedit dengan mudah oleh Admin dan dirender tanpa risiko merusak kerangka desain publik.
