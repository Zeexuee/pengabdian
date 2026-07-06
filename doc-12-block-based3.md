# Dokumentasi Pembuatan CMS Komunitas (Tahap 12 - Video, Slider Multikonten & Resolusi Rute)

Dokumen ini merangkum fase akhir penyempurnaan fitur *Block-Based Page Builder*, mencakup penambahan dukungan format video lokal, slider multi-gambar tanpa *library* eksternal, dan penanganan insiden *routing* di Laravel.

## 1. Ekspansi Modul Admin (Alpine.js)

Dua komponen media dinamis telah disuntikkan ke dalam sistem pembuat halaman:

*   **Tipe `video`**: Didesain khusus untuk menerima unggahan video mandiri dengan *accept types* `video/mp4` dan `video/webm`. Struktur input mempertahankan *string* tunggal standar.
*   **Tipe `slider`**: Komponen paling kompleks di UI, ditujukan untuk membentuk karosel gambar. 
    *   Pengaturan awal (*Default State*) di Alpine diatur menjadi array kosong `[]` ketimbang *string* kosong.
    *   Atribut HTML difasilitasi dengan boolean `multiple`.
    *   **Krusial**: Penamaan elemen menggunakan sufiks array: `name="content_blocks[{{ index }}][content][]"`. Ini mendikte PHP untuk membaca unggahan bukan sebagai satu file, melainkan himpunan (*array of files*).

---

## 2. Pemrosesan Multi-File & Validasi Backend

Logika `Admin\PageController` mengalami perombakan besar untuk mendampingi kedua tipe tersebut:

*   **Validasi Manual Ukuran Video**: Alih-alih bergantung penuh pada Form Request, Controller mengintervensi eksekusi dengan `if ($file->getSize() > 20 * 1024 * 1024)`. Jika video terdeteksi lebih dari 20 Megabyte, proses dibatalkan dan sistem menembakkan pesan *error* kembali ke Administrator, melindungi peladen (*server*) dari eksploitasi beban penyimpanan.
*   **Loop Internal Slider**: Karena *request* datang berbentuk kumpulan file, sistem menjalankan perulangan ganda (*foreach* di dalam *foreach*). Tiap-tiap iterasi gambar diunggah (*stored*), alamat URL-nya dihimpun ke dalam wadah `array` perantara, dan akhirnya *array* tersebut menduduki posisi tunggal `$block['content']` sebelum dienkripsi menjadi JSON.

---

## 3. CSS-Only Slider & Native Video (Frontend)

Prinsip utama CMS ini adalah ringan dan cepat. Alih-alih membebani *browser* pengunjung dengan Swiper.js atau library raksasa lainnya, eksekusinya dilakukan se-nativ mungkin:

*   **Render Video**: Ditampilkan menggunakan utilitas semantik HTML5 `<video controls>`. File dipanggil langsung melalui helper `asset('storage/...')`. 
*   **Render Slider (Tailwind)**: Dirajut murni mengandalkan fitur utilitas CSS. Kontainer dibungkus dengan kelas `flex overflow-x-auto snap-x snap-mandatory scroll-smooth`. Ini memberikan pengalaman geser (*swipe*) pada ponsel dan *scroll* horizontal pada komputer yang akan secara otomatis mengunci (*snap*) gambar di tengah layar dengan mulus dan estetik tanpa secarik pun kode JavaScript.

---

## 4. Resolusi Konflik Rute (Bug Fix)

**Insiden:** Antarmuka Admin dan Halaman Login mendadak memunculkan error `404 Not Found`.

**Akar Masalah:** Penempatan rute dinamis (Catch-All Route) `Route::get('/{slug}')` berada **sebelum/di atas** grup rute `/admin` dan `/login` di dalam `routes/web.php`. Arsitektur Laravel membaca rute secara hirarkis (*Top-Down*). Saat URL `/admin` diakses, rute `{slug}` mencegatnya terlebih dahulu, mengira "admin" adalah judul halaman *Page Builder*, dan gagal menemukannya di *database*.

**Penyelesaian:** Rute penangkap (Catch-all) secara permanen dipindahkan ke **baris paling ujung bawah** dari *file* `routes/web.php`. Tindakan ini memaksa Laravel untuk mengecek dan meloloskan semua URL sistem yang valid terlebih dahulu, menjadikan rute `{slug}` murni sebagai pelabuhan terakhir bagi URL dinamis.
