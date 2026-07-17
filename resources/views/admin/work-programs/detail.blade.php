@extends('layouts.admin')

@section('page_title', 'Kelola Detail: ' . $work_program->title)

@push('scripts')
<script>
    // Toggle form fields berdasarkan tipe yang dipilih
    function toggleTypeFields() {
        const type = document.getElementById('type').value;
        document.getElementById('field-image').classList.toggle('hidden', type !== 'image');
        document.getElementById('field-video').classList.toggle('hidden', type !== 'video');
        document.getElementById('field-text').classList.toggle('hidden',  type !== 'text');
        document.getElementById('field-title').classList.toggle('hidden', type === '');
    }
    document.addEventListener('DOMContentLoaded', toggleTypeFields);
</script>
@endpush

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-wrap justify-between items-start gap-3 mb-6">
    <div>
        <a href="{{ route('admin.work-programs.index') }}" class="text-blue-600 hover:underline text-sm">
            &larr; Kembali ke Daftar Program Kerja
        </a>
        <h2 class="text-lg font-bold text-gray-800 mt-1">{{ $work_program->title }}</h2>
        <p class="text-sm text-gray-500">Kelola konten tambahan yang ditampilkan di halaman detail program ini.</p>
    </div>
    @if($work_program->slug)
        <a href="{{ route('work_programs.detail', $work_program->slug) }}" target="_blank"
           class="inline-flex items-center gap-1.5 text-sm text-gray-600 hover:text-blue-600 border border-gray-300 rounded-lg px-3 py-2 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Halaman Publik
        </a>
    @endif
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Form Tambah Block (kiri) ── --}}
    <div class="lg:col-span-1">
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 sticky top-6">
            <h3 class="font-semibold text-gray-700 mb-4">+ Tambah Konten</h3>

            <form action="{{ route('admin.work-programs.blocks.store', $work_program->id) }}"
                  method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Pilih Tipe --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Konten <span class="text-red-500">*</span></label>
                    <select id="type" name="type" onchange="toggleTypeFields()" required
                            class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>🖼️ Gambar</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>🎬 Video (YouTube)</option>
                        <option value="text"  {{ old('type') === 'text'  ? 'selected' : '' }}>📝 Teks</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Judul (semua tipe) --}}
                <div id="field-title">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul (opsional)</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Judul sub-bagian…">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Field: Gambar --}}
                <div id="field-image" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Gambar <span class="text-red-500">*</span></label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — maks 8 MB</p>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Field: Video --}}
                <div id="field-video" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL YouTube <span class="text-red-500">*</span></label>
                    <input type="url" name="video_url" value="{{ old('video_url') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://www.youtube.com/watch?v=...">
                    @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Field: Teks --}}
                <div id="field-text" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Isi Teks <span class="text-red-500">*</span></label>
                    <textarea name="content" id="block-content" rows="5"
                              class="w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Tulis konten teks di sini…">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                        class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition shadow">
                    Tambah Konten
                </button>
            </form>
        </div>
    </div>

    {{-- ── Daftar Blocks (kanan) ── --}}
    <div class="lg:col-span-2 space-y-4">
        <h3 class="font-semibold text-gray-700">Konten Halaman Detail ({{ $blocks->count() }} item)</h3>

        @forelse($blocks as $block)
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full
                            {{ $block->type === 'image' ? 'bg-green-100 text-green-700' :
                               ($block->type === 'video' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ $block->type === 'image' ? '🖼️ Gambar' : ($block->type === 'video' ? '🎬 Video' : '📝 Teks') }}
                        </span>
                        @if($block->title)
                            <span class="text-sm font-semibold text-gray-700">{{ $block->title }}</span>
                        @endif
                    </div>
                    <form action="{{ route('admin.work-programs.blocks.destroy', [$work_program->id, $block->id]) }}"
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

                <div class="p-4">
                    @if($block->type === 'image' && $block->image)
                        <div class="bg-slate-900 rounded-lg overflow-hidden flex items-center justify-center"
                             style="aspect-ratio:16/9; max-height:260px;">
                            <img src="{{ asset('storage/' . $block->image) }}"
                                 alt="{{ $block->title }}"
                                 class="w-full h-full object-contain">
                        </div>

                    @elseif($block->type === 'video' && $block->video_url)
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
                            <a href="{{ $block->video_url }}" target="_blank" class="text-blue-600 underline text-sm break-all">
                                {{ $block->video_url }}
                            </a>
                        @endif

                    @elseif($block->type === 'text')
                        <div class="prose prose-sm max-w-none text-gray-600 max-h-40 overflow-y-auto">
                            {!! nl2br(e($block->content)) !!}
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M12 4v16m8-8H4"/>
                </svg>
                <p class="text-gray-400 font-medium text-sm">Belum ada konten. Tambahkan dari panel kiri.</p>
            </div>
        @endforelse
    </div>

</div>

@endsection
