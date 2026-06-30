# Dokumentasi Pembuatan CMS Komunitas (Tahap 5 - Penyelesaian Antarmuka Admin CRUD)

Dokumen ini merangkum proses perancangan dan penerapan *Views* (antarmuka grafis) untuk modul-modul CRUD utama pada area Admin (*Backend*). Seluruh antarmuka ini telah didesain secara responsif dengan memadukan **Tailwind CSS** dengan *Master Layout* `layouts/admin.blade.php`.

## 1. Modul Struktur Anggota (`admin/members`)

Modul ini memfasilitasi pembuatan, penayangan, dan pengelolaan hierarki anggota komunitas.

*   **`index.blade.php`**:
    *   Tabel terstruktur rapi yang menyajikan data Anggota.
    *   Fitur visual tambahan: Kolom 'Urutan' ditandai secara menonjol menggunakan bingkai/label abu-abu membulat (*rounded-full*) untuk menekankan struktur hierarkis. Kolom 'Foto' akan memuat foto profil, atau teks indikator 'NA' jika anggota belum memiliki foto.
*   **`create.blade.php` & `edit.blade.php`**:
    *   Atribut Form wajib `enctype="multipart/form-data"` disematkan agar proses transfer *binary* foto berjalan lancar.
    *   Bidang (*field*) `order` dijaga ketat dengan `type="number"` dan batas `min="1"`.
    *   Sistem pembatasan tipe file pada jendela *browser* menggunakan `accept="image/jpeg, image/png, image/webp"`.
    *   **Keistimewaan *Edit***: Tersedia segmen pratinjau (*preview*) foto ukuran 128x128px jika pengguna pernah mengunggah foto sebelumnya.

---

## 2. Modul Program Kerja (`admin/work-programs`)

Modul untuk mencatat inisiatif program dan status berjalannya kalender operasional komunitas.

*   **`index.blade.php`**:
    *   Fitur unggulan modul ini terletak pada *Pewarnaan Lencana Status Dinamis* (Dynamic Status Badge Color) di tabel.
    *   **Abu-abu**: Untuk program yang sekadar 'Direncanakan' (*Planned*).
    *   **Biru**: Untuk program yang 'Sedang Berjalan' (*Ongoing*).
    *   **Hijau**: Untuk program yang telah 'Selesai' (*Completed*).
*   **`create.blade.php` & `edit.blade.php`**:
    *   Penanggalan (Tanggal Mulai dan Tanggal Selesai) memanfaatkan murni antarmuka kalender *browser* melalui `type="date"`.
    *   Pilihan status dibungkus rapi dalam elemen `<select>` *dropdown* yang memuat terjemahan label yang ramah pengguna.
    *   Sama seperti modul anggota, *Edit form* memiliki fitur pratinjau gambar sampul/cover.

---

## 3. Modul Edukasi (`admin/educations`)

Area untuk pengelolaan artikel panjang, konten publikasi ilmiah, maupun basis pengetahuan (*Knowledge Base*) komunitas.

*   **`index.blade.php`**:
    *   Tabel tidak hanya menyorot judul, tetapi turut memunculkan cuplikan URL (*slug path*) di bawah judul.
    *   Menampilkan *badge* publikasi (Hijau untuk 'Dipublikasikan', Oranye untuk 'Draf').
    *   Bila terdapat URL YouTube, *link* dapat langsung diklik (membuka tab baru).
*   **`create.blade.php` & `edit.blade.php`**:
    *   *Grid Layout* Profesional: Formulir dipilah menjadi dua pilar asimetris. Sisi kiri luas menampung penulisan isi artikel (menggunakan elemen `<textarea>` tinggi 10 baris), dan sisi kanan yang menampung unggahan *thumbnail*, *link* video, serta opsi publikasi.
    *   Opsi rilis artikel tidak menggunakan ketikan *text*, melainkan berupa `select dropdown` (*Publikasikan* bernilai `1` / *Simpan Draf* bernilai `0`).
    *   Input *thumbnail* diikat bebas dengan format `accept="image/*"`. Pratinjau *thumbnail* lama tersaji mendominasi ruang atas form *edit*.

## Status Sistem Saat Ini
Dengan tertutupnya Tahap 5, seluruh *backend* aplikasi CMS (Admin Panel) mulai dari *Routing*, *Controller*, hingga presentasi antarmuka HTML telah tersambung sempurna dan siap menampung serta mengelola isi pangkalan data (*database*).
