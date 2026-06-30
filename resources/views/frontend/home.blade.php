@extends('layouts.app')

@section('title', 'Beranda Utama')

@section('content')
<!-- Hero Section Statis -->
<div class="relative bg-gradient-to-br from-blue-900 to-indigo-800 rounded-3xl overflow-hidden shadow-xl mb-16">
    <!-- Overlay/Pattern Halus -->
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
    
    <div class="relative z-10 px-6 py-20 md:py-28 text-center max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
            Menyatukan Langkah, <br class="hidden sm:block">Membangun <span class="text-blue-300">Harapan</span>
        </h1>
        <p class="text-lg md:text-xl text-blue-100 mb-10 font-light px-4">
            Selamat datang di Portal Resmi Komunitas. Kami adalah wadah kolaboratif yang menjunjung tinggi edukasi, aksi sosial, dan program kerja nyata demi memajukan potensi dan kesejahteraan bersama.
        </p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 px-4">
            <a href="{{ route('join') }}" class="px-8 py-4 bg-white text-blue-900 rounded-full font-bold shadow-lg hover:bg-blue-50 transition transform hover:-translate-y-0.5">
                Gabung Bersama Kami
            </a>
            <a href="{{ route('work_programs') }}" class="px-8 py-4 bg-transparent border-2 border-white/50 text-white rounded-full font-bold hover:bg-white/10 hover:border-white transition transform hover:-translate-y-0.5">
                Lihat Program Kerja
            </a>
        </div>
    </div>
</div>

<!-- Section: Berita Terbaru -->
<div class="mb-8">
    <div class="flex justify-between items-end mb-8 border-b-2 border-gray-100 pb-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Berita Terbaru</h2>
            <p class="text-gray-500 mt-2">Kabar dan pembaruan terkini dari berbagai aktivitas komunitas.</p>
        </div>
        <a href="{{ route('news') }}" class="hidden sm:inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition group">
            Lihat Semua Berita 
            <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    <!-- Grid Looping Data $latest_news -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($latest_news as $item)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                
                <!-- Thumbnail -->
                <div class="relative h-48 overflow-hidden bg-gray-100">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-400">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <!-- Label Mengambang -->
                    <div class="absolute top-4 right-4 bg-white/95 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-blue-600 shadow-sm">
                        Baru
                    </div>
                </div>
                
                <!-- Konten Kartu -->
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-xs text-gray-500 mb-2 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $item->published_at ? $item->published_at->format('d M Y') : 'Hari ini' }}
                    </p>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition line-clamp-2">
                        {{ $item->title }}
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow">
                        {!! Str::limit(strip_tags($item->content), 120) !!}
                    </p>
                    
                    <a href="{{ route('news.detail', $item->slug) }}" class="text-blue-600 font-semibold text-sm hover:underline inline-flex items-center mt-auto">
                        Baca Selengkapnya 
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500 font-medium">Belum ada rilis berita terbaru untuk saat ini.</p>
            </div>
        @endforelse
    </div>
    
    <!-- Tombol mobile (muncul hanya di layar kecil) -->
    <div class="mt-8 text-center sm:hidden">
        <a href="{{ route('news') }}" class="inline-block w-full py-3 px-4 bg-blue-50 text-blue-700 font-bold rounded-lg hover:bg-blue-100 transition">
            Lihat Semua Berita
        </a>
    </div>
</div>
@endsection
