@extends('layouts.admin')

@section('page_title', 'Edit Halaman (Block-Based)')

@section('content')
<div x-data="pageBuilder()">
    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Halaman</label>
            <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (Opsional)</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk membuat slug otomatis dari judul.</p>
        </div>

        <!-- Pengaturan SEO -->
        <div class="mb-4 p-4 border rounded-md bg-white shadow-sm">
            <h4 class="text-md font-semibold text-gray-800 mb-4">Pengaturan SEO (Opsional)</h4>
            <div class="mb-4">
                <label for="meta_title" class="block text-sm font-medium text-gray-700">Meta Title</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="Judul khusus untuk SEO (jika kosong, menggunakan Judul Halaman)">
            </div>
            <div class="mb-4">
                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" placeholder="Deskripsi singkat untuk SEO">{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
            <div>
                <label for="meta_image" class="block text-sm font-medium text-gray-700">Meta Image (og:image)</label>
                @if($page->meta_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $page->meta_image) }}" alt="Meta Image" class="h-32 object-cover rounded shadow-sm">
                    </div>
                @endif
                <input type="file" name="meta_image" id="meta_image" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar.</p>
            </div>
        </div>

        <hr class="my-6 border-gray-300">

        <h3 class="text-lg font-medium text-gray-900 mb-4">Susunan Konten (Blocks)</h3>

        <!-- Render Blocks -->
        <div class="space-y-4 mb-6">
            <template x-for="(block, index) in blocks" :key="block.id || index">
                <div class="p-4 border rounded-md bg-gray-50 relative border-gray-200">
                    <!-- Tombol Aksi Block -->
                    <div class="absolute top-2 right-2 flex space-x-2">
                        <button type="button" @click="if(index > 0) { let temp = blocks[index]; blocks[index] = blocks[index-1]; blocks[index-1] = temp; }" class="text-gray-500 hover:text-gray-700" title="Naik">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        </button>
                        <button type="button" @click="if(index < blocks.length - 1) { let temp = blocks[index]; blocks[index] = blocks[index+1]; blocks[index+1] = temp; }" class="text-gray-500 hover:text-gray-700" title="Turun">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <button type="button" @click="removeBlock(index)" class="text-red-500 hover:text-red-700" title="Hapus">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <div class="mb-2">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider" x-text="'Tipe: ' + block.type"></span>
                        <input type="hidden" :name="`content_blocks[${index}][type]`" :value="block.type">
                    </div>

                    <!-- Input berdasarkan tipe block -->
                    <template x-if="block.type === 'judul'">
                        <input type="text" :name="`content_blocks[${index}][content]`" x-model="block.content" placeholder="Masukkan Judul (H2/H3)..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required>
                    </template>

                    <template x-if="block.type === 'teks'">
                        <textarea :name="`content_blocks[${index}][content]`" x-model="block.content" rows="4" placeholder="Masukkan teks paragraf..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required></textarea>
                    </template>

                    <template x-if="block.type === 'gambar'">
                        <div>
                            <p class="text-sm text-gray-700 mb-1" x-show="block.content && typeof block.content === 'string' && block.content.length > 0">Gambar Saat Ini: <a :href="'/storage/' + block.content" target="_blank" class="text-blue-500 underline">Lihat Gambar</a></p>
                            <input type="file" :name="`content_blocks[${index}][content]`" accept="image/*" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                            <p class="mt-1 text-sm text-gray-500">Pilih file gambar baru untuk mengganti yang lama (opsional).</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'video_youtube'">
                        <div>
                            <input type="text" :name="`content_blocks[${index}][content]`" x-model="block.content" placeholder="Masukkan ID Video YouTube (contoh: dQw4w9WgXcQ)" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required>
                            <p class="text-xs text-gray-500 mt-1">Hanya ID video, bukan URL penuh.</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'iframe'">
                        <div>
                            <textarea :name="`content_blocks[${index}][content]`" x-model="block.content" rows="4" placeholder="Tempelkan kode <iframe> lengkap di sini..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border font-mono text-sm" required></textarea>
                            <p class="text-xs text-gray-500 mt-1">Hati-hati, kode akan dirender langsung (unescaped).</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'tabel'">
                        <div>
                            <textarea :name="`content_blocks[${index}][content]`" x-model="block.content" rows="6" placeholder="Nama,Jabatan,Umur&#10;Budi,Ketua,30&#10;Siti,Wakil,28" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border font-mono text-sm" required></textarea>
                            <p class="text-xs text-gray-500 mt-1">Gunakan format CSV sederhana.</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'file'">
                        <div>
                            <p class="text-sm text-gray-700 mb-1" x-show="block.content && typeof block.content === 'string' && block.content.length > 0">File Saat Ini: <a :href="'/storage/' + block.content" target="_blank" class="text-blue-500 underline">Unduh File</a></p>
                            <input type="file" :name="`content_blocks[${index}][content]`" accept=".pdf,.doc,.docx" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                            <p class="mt-1 text-sm text-gray-500">Pilih dokumen baru untuk mengganti yang lama (opsional).</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'grup_teks_gambar'">
                        <div class="flex flex-col md:flex-row md:space-x-4 space-y-4 md:space-y-0">
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Teks (Paragraf)</label>
                                <textarea :name="`content_blocks[${index}][content][teks]`" x-model="block.content.teks" rows="4" placeholder="Masukkan teks deskripsi..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required></textarea>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Upload Gambar</label>
                                <p class="text-xs text-gray-700 mb-1" x-show="block.content && block.content.gambar">Gambar Saat Ini: <a :href="'/storage/' + block.content.gambar" target="_blank" class="text-blue-500 underline">Lihat</a></p>
                                <input type="file" :name="`content_blocks[${index}][content][gambar]`" accept="image/*" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                                <p class="mt-1 text-xs text-gray-500">Pilih gambar baru (opsional).</p>
                            </div>
                        </div>
                    </template>

                    <template x-if="block.type === 'video'">
                        <div>
                            <p class="text-sm text-gray-700 mb-1" x-show="block.content && typeof block.content === 'string' && block.content.length > 0">Video Saat Ini Tersimpan.</p>
                            <input type="file" :name="`content_blocks[${index}][content]`" accept="video/mp4,video/webm" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                            <p class="mt-1 text-sm text-gray-500">Pilih file video baru untuk mengganti (opsional).</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'slider'">
                        <div>
                            <p class="text-sm text-gray-700 mb-1" x-show="block.content && Array.isArray(block.content) && block.content.length > 0">Memiliki <span x-text="block.content.length"></span> Gambar Tersimpan.</p>
                            <input type="file" :name="`content_blocks[${index}][content][]`" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                            <p class="mt-1 text-xs text-red-500">Maksimal 5 gambar. Mengunggah gambar baru akan menimpa seluruh slider lama.</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'grup_teks'">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Teks Kolom 1</label>
                                <textarea :name="`content_blocks[${index}][content][kolom_1]`" x-model="block.content.kolom_1" rows="4" placeholder="Masukkan teks kolom pertama..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Teks Kolom 2</label>
                                <textarea :name="`content_blocks[${index}][content][kolom_2]`" x-model="block.content.kolom_2" rows="4" placeholder="Masukkan teks kolom kedua..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required></textarea>
                            </div>
                        </div>
                    </template>

                    <template x-if="block.type === 'grup_gambar'">
                        <div>
                            <p class="text-sm text-gray-700 mb-1" x-show="block.content && Array.isArray(block.content) && block.content.length > 0">Memiliki <span x-text="block.content.length"></span> Gambar Tersimpan.</p>
                            <input type="file" :name="`content_blocks[${index}][content][]`" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 p-2">
                            <p class="mt-1 text-sm text-gray-500">Mengunggah file baru akan menimpa grup gambar lama.</p>
                        </div>
                    </template>

                    <template x-if="block.type === 'tab'">
                        <div class="space-y-4">
                            <template x-for="(tab, tabIndex) in block.content" :key="tabIndex">
                                <div class="p-3 border border-gray-200 rounded relative bg-white">
                                    <button type="button" @click="block.content.splice(tabIndex, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 text-xs font-medium">Hapus Tab</button>
                                    
                                    <div class="mb-2">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Judul Tab</label>
                                        <input type="text" :name="`content_blocks[${index}][content][${tabIndex}][judul_tab]`" x-model="tab.judul_tab" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Isi Tab</label>
                                        <textarea :name="`content_blocks[${index}][content][${tabIndex}][isi_tab]`" x-model="tab.isi_tab" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border" required></textarea>
                                    </div>
                                </div>
                            </template>
                            <button type="button" @click="block.content.push({ judul_tab: 'Tab Baru', isi_tab: '' })" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">+ Tambah Tab</button>
                        </div>
                    </template>

                    <template x-if="block.type === 'widget'">
                        <div>
                            <select :name="`content_blocks[${index}][content]`" x-model="block.content" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border bg-white" required>
                                <option value="" disabled>-- Pilih Widget --</option>
                                <option value="widget_anggota">Tampilkan Struktur Anggota</option>
                                <option value="widget_program">Tampilkan Program Kerja</option>
                                <option value="widget_berita">Tampilkan Berita Terbaru</option>
                            </select>
                        </div>
                    </template>
                </div>
            </template>
            
            <div x-show="blocks.length === 0" class="text-center py-6 text-gray-500 italic border-2 border-dashed rounded-md border-gray-300">
                Belum ada block konten. Silakan tambah block baru.
            </div>
        </div>

        <!-- Tombol Tambah Block -->
        <div class="mb-8 p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h4 class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wider">Tambah Komponen</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                <button type="button" @click="addBlock('judul')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Judul
                </button>
                <button type="button" @click="addBlock('teks')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Teks
                </button>
                <button type="button" @click="addBlock('gambar')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Gambar
                </button>
                <button type="button" @click="addBlock('video_youtube')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Video Youtube
                </button>
                <button type="button" @click="addBlock('iframe')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    iFrame
                </button>
                <button type="button" @click="addBlock('video')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Video
                </button>
                <button type="button" @click="addBlock('file')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    File
                </button>
                <button type="button" @click="addBlock('slider')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Slider
                </button>
                <button type="button" @click="addBlock('grup_teks')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Grup Teks
                </button>
                <button type="button" @click="addBlock('grup_gambar')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Grup Gambar
                </button>
                <button type="button" @click="addBlock('grup_teks_gambar')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Grup Teks & Gambar
                </button>
                <button type="button" @click="addBlock('tabel')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Tabel
                </button>
                <button type="button" @click="addBlock('tab')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Tab
                </button>
                <button type="button" @click="addBlock('widget')" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Widget Modul
                </button>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow-sm font-medium">
                Update Halaman
            </button>
            <a href="{{ route('admin.pages.index') }}" class="ml-2 text-gray-600 hover:text-gray-900 text-sm">Batal</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<!-- Inject Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('pageBuilder', () => ({
            blocks: @json(old('content_blocks', $page->content_blocks ?? [])),
            
            addBlock(type) {
                let initialContent = '';
                if (type === 'grup_teks_gambar') {
                    initialContent = { teks: '', gambar: '' };
                } else if (type === 'grup_teks') {
                    initialContent = { kolom_1: '', kolom_2: '' };
                } else if (type === 'slider' || type === 'grup_gambar') {
                    initialContent = [];
                } else if (type === 'tab') {
                    initialContent = [{ judul_tab: 'Tab 1', isi_tab: '' }];
                } else if (type === 'widget') {
                    initialContent = '';
                }

                // Attach ID fallback because old data might lack 'id'
                this.blocks.push({
                    id: Date.now(),
                    type: type,
                    content: initialContent
                });
            },

            removeBlock(index) {
                this.blocks.splice(index, 1);
            }
        }));
    });
</script>
@endpush
