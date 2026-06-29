@extends('layouts.app')

@section('title', 'Berita Terkini')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-6">Berita Terkini</h1>
    <p class="text-gray-600 max-w-2xl">Dapatkan informasi, pengumuman, dan artikel terbaru dari aktivitas komunitas kami.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($news as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col">
            <!-- Thumbnail Gambar -->
            @if($item->thumbnail)
                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-56 object-cover">
            @else
                <div class="w-full h-56 bg-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="sr-only">Tanpa Gambar</span>
                </div>
            @endif
            
            <div class="p-6 flex-grow flex flex-col">
                <!-- Tanggal Publikasi -->
                <p class="text-xs text-blue-600 font-bold mb-3 uppercase tracking-wider flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $item->published_at ? $item->published_at->format('d M Y') : 'Baru Saja' }}
                </p>
                
                <!-- Judul Berita -->
                <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 hover:text-blue-600 transition">
                    {{ $item->title }}
                </h3>
                
                <!-- Cuplikan Konten -->
                <div class="text-gray-600 text-sm mb-6 flex-grow line-clamp-3">
                    {{ Str::limit(strip_tags($item->content), 120) }}
                </div>
                
                <!-- Tombol Baca -->
                <a href="#" class="inline-block w-full px-4 py-2 bg-gray-50 text-blue-700 rounded-md hover:bg-blue-600 hover:text-white transition-colors duration-200 text-sm font-semibold text-center mt-auto border border-gray-100 hover:border-transparent">
                    Baca Berita Penuh
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-20 text-gray-500 bg-white rounded-xl border-2 border-dashed border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20" />
            </svg>
            <p class="text-lg font-medium text-gray-600">Belum ada berita yang dipublikasikan saat ini.</p>
            <p class="text-sm mt-2">Coba kembali lagi nanti.</p>
        </div>
    @endforelse
</div>

<!-- Navigasi Halaman (Pagination) -->
@if(isset($news) && $news->hasPages())
    <div class="mt-12 bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
        {{ $news->links() }}
    </div>
@endif
@endsection
