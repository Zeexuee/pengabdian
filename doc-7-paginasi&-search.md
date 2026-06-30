# Dokumentasi Pembuatan CMS Komunitas (Tahap 7 - Paginasi & Pencarian Data)

Dokumen ini mendeskripsikan implementasi sistem Paginasi (pembatasan muat data) dan fitur Pencarian Kueri (Search) pada keseluruhan proyek CMS, baik di sisi *Backend* (Admin) maupun *Frontend* (Publik). Kedua fitur ini krusial untuk mencegah pembebanan server dan memastikan pengalaman pengguna tetap responsif meskipun data di dalam database bertambah masif.

## 1. Paginasi & Pencarian pada Sisi Admin (Backend)

Seluruh metode `index` pada kelima Controller Admin (Berita, Anggota, Program Kerja, Edukasi, Kontak, Permintaan Gabung) telah diperbarui dengan alur logika berikut:

*   **Penerimaan Kueri Pencarian**: Controller kini mendengarkan *query string* `?search=` dari URL. Jika parameter ini mengandung nilai, sistem akan melampirkan klausa SQL tambahan (menggunakan `WHERE ... LIKE %keyword%`).
    *   *Modul Konten (Berita/Edukasi/Program)* berfokus mencari parameter kecocokan pada kolom `title`.
    *   *Modul Partisipan (Anggota/Kontak/Request)* berfokus memindai kecocokan majemuk menggunakan kombinasi klausa pembantu `orWhere` (misal mencari di kolom `name` ATAU `email` ATAU `position`).
*   **Pembatasan Data (Pagination)**: Metode `get()` dan `all()` yang agresif telah digantikan secara mutlak dengan metode `paginate(10)`. Ini memaksa pangkalan data untuk mengembalikan maksimal 10 baris (*records*) pada setiap permintaan muat.
*   **Persistensi Parameter (Query String)**: Modifikasi paling esensial berada pada penambahan penaut `->withQueryString()` di *Controller* dan `appends(request()->query())` pada sintaks Blade. Fungsinya adalah agar URL navigasi (contoh: Pindah ke Halaman 2) selalu mewarisi filter pencarian sebelumnya (sehingga link menjadi `?search=rapat&page=2`, bukan reset menjadi sekadar `?page=2`).
*   **Antarmuka Pencari (View)**: Sebuah elemen `<form method="GET">` disuntikkan secara persisten di halaman *List* (misalnya pada tabel Berita) yang secara otomatis akan menahan nilai input pencarian sebelumnya via sintaks `value="{{ request('search') }}"`.

## 2. Paginasi & Optimalisasi Sisi Publik (Frontend)

Kecepatan muat (Time-To-First-Byte) bagi audiens publik dipertahankan dengan merampingkan *FrontEndController*:

*   **Skala Tampilan Grid**: Fungsi `educations()` dan `news()` telah diproteksi agar hanya mengangkut maksimal 9 artikel per halaman (`paginate(9)`). Angka ganjil ini sengaja dipilih sebab layout arsitektur di sisi *frontend* menggunakan grid 3-kolom, sehingga penayangan akhir selalui genap menutupi batas pinggir tata letak visual tanpa menyisakan 1 baris timpang.
*   **Direktif View**: Halaman *Frontend* kini memiliki kaki penampil paginasi (melalui direktif `{{ $data->links() }}`).

## 3. Registrasi Paginator Global (AppServiceProvider)

Secara bawaan (*default*), komponen `->links()` dari Laravel akan merender sintaks HTML/CSS milik *framework Bootstrap*. Karena ekosistem CMS ini murni bersandar pada utilitas **Tailwind CSS**, Paginator global perlu dipaksa berpindah haluan.
Langkah penyesuaian dieksekusi pada `app/Providers/AppServiceProvider.php` dengan mendaftarkan:

```php
use Illuminate\Pagination\Paginator;

public function boot(): void
{
    Paginator::useTailwind();
}
```

## Status Sistem Saat Ini
Sistem CMS kini kebal terhadap ledakan volume data (Overloading). Data ribuan baris pun akan dimuat dan dinavigasi secara ringan berkat isolasi per 10 baris, didukung dengan penyaringan hasil (pencarian) yang akurat.
