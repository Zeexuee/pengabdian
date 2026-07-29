@extends('layouts.admin')

@section('page_title', 'Kelola Detail Berita: ' . $news->title)

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    let blockEditor;
    const editEditors = {};

    function toggleTypeFields() {
        const type = document.getElementById('type').value;
        document.getElementById('field-image').classList.toggle('hidden', type !== 'image');
        document.getElementById('field-video').classList.toggle('hidden', type !== 'video');
        document.getElementById('field-text').classList.toggle('hidden',  type !== 'text');
        document.getElementById('field-title').classList.toggle('hidden', type === '');
    }

    function toggleEditTypeFields(blockId) {
        const type = document.getElementById('edit-type-' + blockId).value;
        document.getElementById('edit-field-image-' + blockId).classList.toggle('hidden', type !== 'image');
        document.getElementById('edit-field-video-' + blockId).classList.toggle('hidden', type !== 'video');
        document.getElementById('edit-field-text-' + blockId).classList.toggle('hidden',  type !== 'text');
    }

    function toggleEditBlock(blockId) {
        const editFormWrapper = document.getElementById('edit-block-' + blockId);
        const isHidden = editFormWrapper.classList.contains('hidden');
        
        if (!isHidden) {
            editFormWrapper.classList.add('hidden');
            return;
        }

        editFormWrapper.classList.remove('hidden');
        toggleEditTypeFields(blockId);

        const textareaSelector = '#edit-content-' + blockId;
        const textareaEl = document.querySelector(textareaSelector);
        if (textareaEl && !editEditors[blockId]) {
            ClassicEditor
                .create(textareaEl)
                .then(editor => {
                    editEditors[blockId] = editor;
                    editor.model.document.on('change:data', () => {
                        textareaEl.value = editor.getData();
                    });
                })
                .catch(error => { console.error(error); });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleTypeFields();

        if (document.querySelector('#block-content')) {
            ClassicEditor
                .create(document.querySelector('#block-content'))
                .then(editor => {
                    blockEditor = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#block-content').value = editor.getData();
                    });
                })
                .catch(error => { console.error(error); });
        }

        const blockForm = document.querySelector('form[action*="blocks"]');
        if (blockForm) {
            blockForm.addEventListener('submit', function (e) {
                const type = document.getElementById('type').value;
                if (type === 'text' && blockEditor) {
                    const data = blockEditor.getData();
                    document.querySelector('#block-content').value = data;
                    if (!data.trim()) {
                        e.preventDefault();
                        alert('Isi Teks tidak boleh kosong.');
                    }
                }
            });
        }

        // ── Drag & Drop Reorder Component Blocks ──
        const sortableContainer = document.getElementById('sortable-blocks');
        if (sortableContainer) {
            Sortable.create(sortableContainer, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'opacity-40',
                onEnd: function () {
                    const items = [];
                    sortableContainer.querySelectorAll('div[data-id]').forEach(function (div, index) {
                        items.push({ id: div.getAttribute('data-id'), order: index + 1 });
                    });

                    if (items.length === 0) return;

                    fetch('{{ url("admin/news/" . $news->id . "/blocks/reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orders: items })
                    }).then(r => r.json()).then(data => {
                        if (data.success) {
                            sortableContainer.style.transition = 'opacity 0.2s';
                            sortableContainer.style.opacity = '0.5';
                            setTimeout(() => sortableContainer.style.opacity = '1', 300);
                        }
                    });
                }
            });
        }
    });

    function handleEditSubmit(e, blockId) {
        const type = document.getElementById('edit-type-' + blockId).value;
        if (type === 'text' && editEditors[blockId]) {
            const data = editEditors[blockId].getData();
            document.querySelector('#edit-content-' + blockId).value = data;
            if (!data.trim()) {
                e.preventDefault();
                alert('Isi Teks tidak boleh kosong.');
            }
        }
    }
</script>
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="flex flex-wrap justify-between items-start gap-3 mb-6">
    <div>
        <a href="{{ route('admin.news.index') }}" class="text-red-600 hover:underline text-sm font-semibold">
            &larr; Kembali ke Daftar Berita
        </a>
        <h2 class="text-xl font-bold text-gray-800 mt-1">{{ $news->title }}</h2>
        <p class="text-sm text-gray-500">Kelola konten tambahan (teks berformat Word, gambar pendukung, video MP4/YouTube) yang ditampilkan di halaman detail berita ini.</p>
    </div>
    @if($news->slug)
        <a href="{{ route('news.detail', $news->slug) }}" target="_blank"
           class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-red-600 border border-gray-300 bg-white rounded-lg px-3 py-2 shadow-sm transition">
            Lihat Halaman Publik
        </a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Form Tambah Block (kiri) --}}
    <div class="lg:col-span-5">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 sticky top-6 shadow-sm">
            <h3 class="font-bold text-gray-800 text-base mb-4">
                Tambah Konten Detail Berita
            </h3>

            <form action="{{ route('admin.news.blocks.store', $news->id) }}"
                  method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Pilih Tipe --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Konten <span class="text-red-500">*</span></label>
                    <select id="type" name="type" onchange="toggleTypeFields()" required
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="text"  {{ old('type', 'text') === 'text'  ? 'selected' : '' }}>Teks (Rich Text / Format Word)</option>
                        <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Gambar Pendukung</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video (File MP4 / YouTube)</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Judul (semua tipe) --}}
                <div id="field-title">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Sub-Bagian (opsional)</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-red-500 focus:border-red-500"
                           placeholder="Judul sub-bagian…">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Field: Gambar --}}
                <div id="field-image" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar <span class="text-red-500">*</span></label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — maks 8 MB</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Field: Video --}}
                <div id="field-video" class="hidden space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Video Langsung (.mp4, .webm, .mov)</label>
                        <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime"
                               class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                        <p class="text-xs text-gray-400 mt-1">Format: MP4, WEBM, MOV (Maks: 100 MB)</p>
                        @error('video_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="flex-shrink mx-2 text-xs text-gray-400 font-semibold uppercase">Atau Link YouTube</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL YouTube</label>
                        <input type="url" name="video_url" value="{{ old('video_url') }}"
                               class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-red-500 focus:border-red-500"
                               placeholder="https://www.youtube.com/watch?v=...">
                        @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Field: Teks --}}
                <div id="field-text" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Teks (Format Word) <span class="text-red-500">*</span></label>
                    <textarea name="content" id="block-content" rows="8"
                              class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-red-500 focus:border-red-500"
                              placeholder="Tulis konten berita di sini…">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shadow">
                    Tambah Konten
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Blocks (kanan) --}}
    <div class="lg:col-span-7 space-y-4">
        <div>
            <h3 class="font-bold text-gray-800 text-base">Konten Halaman Detail ({{ $blocks->count() }} item)</h3>
            <p class="text-xs text-gray-500 mt-1">Gunakan ikon <strong>⋮⋮ (Drag)</strong> di sebelah kiri setiap kartu untuk mengubah urutan tampilan komponen secara bebas.</p>
        </div>

        <div id="sortable-blocks" class="space-y-4">
            @forelse($blocks as $block)
                <div data-id="{{ $block->id }}" class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <div class="flex items-center gap-2">
                            <span class="drag-handle cursor-move text-gray-400 font-extrabold px-1.5 py-0.5 bg-gray-200/70 hover:bg-red-100 hover:text-red-600 rounded select-none text-xs" title="Geser untuk mengatur urutan">⋮⋮</span>
                            <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full
                                {{ $block->type === 'image' ? 'bg-green-100 text-green-700' :
                                   ($block->type === 'video' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">
                                {{ $block->type === 'image' ? 'Gambar' : ($block->type === 'video' ? 'Video' : 'Teks') }}
                            </span>
                            @if($block->title)
                                <span class="text-sm font-semibold text-gray-700">{{ $block->title }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="toggleEditBlock({{ $block->id }})"
                                    class="text-xs text-blue-600 hover:text-blue-800 font-semibold transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.news.blocks.destroy', [$news->id, $block->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus konten ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-xs text-red-500 hover:text-red-700 font-semibold transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Form Edit Inline (Hidden default) --}}
                    <div id="edit-block-{{ $block->id }}" class="hidden p-4 border-b border-gray-200 bg-gray-50/80">
                        <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wide mb-3">Edit Konten</h4>
                        <form action="{{ route('admin.news.blocks.update', [$news->id, $block->id]) }}"
                              method="POST" enctype="multipart/form-data" class="space-y-3"
                              onsubmit="handleEditSubmit(event, {{ $block->id }})">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Tipe Konten <span class="text-red-500">*</span></label>
                                <select id="edit-type-{{ $block->id }}" name="type" onchange="toggleEditTypeFields({{ $block->id }})" required
                                        class="w-full border-gray-300 rounded-lg shadow-sm text-xs focus:ring-red-500 focus:border-red-500">
                                    <option value="text"  {{ $block->type === 'text'  ? 'selected' : '' }}>Teks (Rich Text)</option>
                                    <option value="image" {{ $block->type === 'image' ? 'selected' : '' }}>Gambar</option>
                                    <option value="video" {{ $block->type === 'video' ? 'selected' : '' }}>Video (File MP4 / YouTube)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Judul Sub-Bagian (opsional)</label>
                                <input type="text" name="title" value="{{ old('title', $block->title) }}"
                                       class="w-full border-gray-300 rounded-lg shadow-sm text-xs focus:ring-red-500 focus:border-red-500">
                            </div>

                            <div id="edit-field-image-{{ $block->id }}" class="hidden">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Ganti Gambar (opsional)</label>
                                @if($block->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $block->image) }}" class="h-20 object-contain rounded border">
                                    </div>
                                @endif
                                <input type="file" name="image" accept="image/*" class="w-full text-xs">
                            </div>

                            <div id="edit-field-video-{{ $block->id }}" class="hidden space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Upload / Ganti File Video (.mp4, .webm, .mov)</label>
                                    @if($block->video_file)
                                        <div class="mb-2">
                                            <video controls class="max-h-32 w-full rounded border bg-black">
                                                <source src="{{ asset('storage/' . $block->video_file) }}">
                                            </video>
                                        </div>
                                    @endif
                                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" class="w-full text-xs">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Atau URL YouTube</label>
                                    <input type="url" name="video_url" value="{{ old('video_url', $block->video_url) }}"
                                           class="w-full border-gray-300 rounded-lg shadow-sm text-xs focus:ring-red-500 focus:border-red-500">
                                </div>
                            </div>

                            <div id="edit-field-text-{{ $block->id }}" class="hidden">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Isi Teks</label>
                                <textarea name="content" id="edit-content-{{ $block->id }}" rows="6"
                                          class="w-full border-gray-300 rounded-lg shadow-sm text-xs focus:ring-red-500 focus:border-red-500">{{ old('content', $block->content) }}</textarea>
                            </div>

                            <div class="flex justify-end gap-2 pt-2">
                                <button type="button" onclick="toggleEditBlock({{ $block->id }})"
                                        class="px-3 py-1.5 text-xs bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-1.5 text-xs bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Preview Content --}}
                    <div class="p-4">
                        @if($block->type === 'image' && $block->image)
                            <div class="bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center"
                                 style="aspect-ratio:16/9; max-height:260px;">
                                <img src="{{ asset('storage/' . $block->image) }}"
                                     alt="{{ $block->title }}"
                                     class="w-full h-full object-contain">
                            </div>

                        @elseif($block->type === 'video')
                            @if($block->video_file)
                                <div class="rounded-lg overflow-hidden bg-black flex items-center justify-center">
                                    <video controls class="w-full max-h-[360px] rounded-lg">
                                        <source src="{{ asset('storage/' . $block->video_file) }}">
                                        Browser Anda tidak mendukung pemutaran video HTML5.
                                    </video>
                                </div>
                            @elseif($block->video_url)
                                @php
                                    $vid = '';
                                    preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $block->video_url, $m);
                                    if (isset($m[1])) $vid = $m[1];
                                @endphp
                                @if($vid)
                                    <div style="position:relative;padding-top:56.25%;border-radius:.5rem;overflow:hidden;">
                                        <iframe src="https://www.youtube.com/embed/{{ $vid }}"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <a href="{{ $block->video_url }}" target="_blank" class="text-red-600 underline text-sm break-all">
                                        {{ $block->video_url }}
                                    </a>
                                @endif
                            @endif

                        @elseif($block->type === 'text')
                            <div class="prose prose-sm max-w-none text-gray-700 max-h-48 overflow-y-auto">
                                @if(Str::startsWith(trim($block->content), '<'))
                                    {!! $block->content !!}
                                @else
                                    {!! nl2br(e($block->content)) !!}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-400 font-medium text-sm">Belum ada konten detail berita. Tambahkan dari panel kiri.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

@endsection
