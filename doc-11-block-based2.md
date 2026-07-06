# Dokumentasi Pembuatan CMS Komunitas (Tahap 11 - Ekspansi Kompleksitas Block-Based)

Dokumen ini merupakan kelanjutan dari seri integrasi *Block-Based Page Builder*, mencakup penambahan modul data ganda bersarang (*nested array*) dan manajemen file terpadu.

## 1. Integrasi Modul Baru di Alpine.js (Antarmuka Admin)

Kemampuan *Page Builder* telah diperluas untuk menangani tipe data operasional yang lebih masif:

*   **Tipe `file`**: Dikhususkan untuk menangani lampiran dokumen (seperti PDF, DOC, DOCX).
*   **Tipe `grup_teks_gambar`**: Sebuah blok unik yang merepresentasikan struktur data ganda. Alih-alih menyimpan *string* murni, blok ini diinisiasi dengan objek JSON di Alpine.js: `content: { teks: '', gambar: '' }`.
*   **UI Input Ganda**: Pada tampilan Admin, blok grup ini secara otomatis dirender menggunakan arsitektur Flexbox (`flex-col md:flex-row`), mendampingkan *textarea* (untuk teks deskriptif) bersebelahan dengan *input file* (untuk gambar pendamping).

---

## 2. Peningkatan Logika Penyimpanan Bersarang (Backend)

Perluasan bentuk *array* menjadi *multidimensional object* menuntut pemutakhiran ekstrem pada `Admin\PageController`:

*   **Penanganan Tipe 'File'**: Logikanya telah disatukan secara efisien dengan tipe 'gambar' menggunakan kondisi majemuk `in_array($block['type'], ['gambar', 'file'])`.
*   **Penetrasi *Nested Array***: Untuk mengambil file gambar yang bersarang di dalam blok grup, *Controller* melakukan ekstraksi via *dot-notation*: `$request->hasFile("content_blocks.{$index}.content.gambar")`.
*   **Manajemen Pembaruan Parsial (Partial Update)**:
    Sistem telah dirancang kebal terhadap insiden penghapusan data sepihak. Apabila admin melakukan pembaruan (*Update*) pada teks tanpa melampirkan gambar pengganti yang baru, sistem akan memicu *fallback* cerdas:
    `$block['content']['gambar'] = $oldBlocks[$index]['content']['gambar']`
    Ini mengkloning data string *path* gambar sebelumnya dari *database*, memastikan gambar tidak lenyap/tertimpa null.
*   **Keamanan Anti-Tabrakan**: Sepenuhnya bergantung pada metode primitif Laravel `$request->file()->store('pages', 'public')`, nama dokumen orisinal yang diunggah (*misal: laporan-akhir.pdf*) akan ditolak dan digantikan secara absolut dengan *Hash String* acak 40 karakter. Risiko tertimpanya gambar/file antar-blok pun tereliminasi utuh (100% *Zero-Collision*).

---

## 3. Eksekusi Visual di Antarmuka Publik (Frontend)

File `resources/views/frontend/page.blade.php` telah dirangkai untuk memberikan presentasi visual yang responsif atas dua komponen mutakhir di atas:

*   **Render `file`**: Dicetak bukan sebagai teks telanjang, melainkan dikonversi wujudnya menjadi komponen Tombol CTA (*Call to Action*) "Unduh Dokumen". Dihiasi polesan Tailwind CSS (warna dasar *Blue-600*, *hover states*, ikon unduh SVG), dan mengarahkan peladen untuk membukanya di jendela terpisah (`target="_blank"`).
*   **Render `grup_teks_gambar`**: Menghindari tata letak tumpang tindih, presentasi blok ini dikendalikan oleh **Tailwind Grid** hibrida:
    `<div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">`
    *   Pada ranah layar sempit (Peranti Seluler), teks dan gambar ditumpuk lurus vertikal (*1 column*).
    *   Pada resolusi menengah dan lebar (Tablet/Desktop), struktur bergeser halus menjadi penjajaran horizontal (*2 columns*), dengan teks memadati kubus kiri dan gambar menempati kubus kanan secara simetris.

Penyelesaian tahap ini menandai bahwa CMS Anda tidak hanya handal menangani elemen terpisah, melainkan mampu mengorkestrasi relasi elemen bersarang (*Nested Elements*) dengan standar reliabilitas tinggi.
