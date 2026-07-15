@extends('layouts.app')

@section('title', 'Beranda Utama')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* Styling for custom scrollbar in image_text component */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1; 
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8; 
    }
    
    /* Swiper: force slides to fill container */
    .hero-swiper {
        overflow: hidden;
        position: relative;
    }
    .hero-swiper .swiper-slide {
        width: 100% !important;
        height: 100%;
    }
    .hero-swiper .swiper-pagination {
        bottom: 16px !important;
    }
    .hero-swiper .swiper-pagination-bullet {
        background: rgba(255, 255, 255, 0.7);
        opacity: 1;
        width: 10px;
        height: 10px;
        transition: all 0.3s ease;
    }
    .hero-swiper .swiper-pagination-bullet-active {
        background: #2563eb;
        width: 24px;
        border-radius: 5px;
    }
</style>
@endpush

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var heroEl = document.querySelector('.hero-swiper');
        if (heroEl) {
            new Swiper('.hero-swiper', {
                loop: true,
                autoplay: {
                    delay: 10000,
                    disableOnInteraction: false,
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                speed: 1000,
            });
        }
    });
</script>
@endpush

@section('full_width_content')
<!-- Dynamic Hero Carousel Section (Full Cover) -->
@if($hero_slides->count() > 0)
    <div class="swiper hero-swiper w-full" style="height: 70vh; min-height: 300px;">
        <div class="swiper-wrapper">
            @foreach($hero_slides as $slide)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Hero Banner" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
@endif
@endsection

@section('content')

<!-- Area Konten Utama Dinamis -->
<div class="space-y-12 md:space-y-16 mb-16">
    @foreach($sections as $section)
        
        <!-- Komponen Gambar Tunggal -->
        @if($section->type == 'image')
            <div class="w-full">
                @if($section->title)
                    <h2 class="text-2xl md:text-3xl font-bold text-center mb-4 md:mb-6">{{ $section->title }}</h2>
                @endif
                @if($section->image)
                    <img src="{{ asset('storage/' . $section->image) }}" class="w-full rounded-2xl shadow-lg object-cover" alt="{{ $section->title }}">
                @endif
            </div>

        <!-- Komponen Teks -->
        @elseif($section->type == 'text')
            <div class="max-w-4xl mx-auto bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                @if($section->title)
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6 text-gray-900">{{ $section->title }}</h2>
                @endif
                <div class="prose prose-sm md:prose-lg prose-blue max-w-none text-gray-700 max-h-[300px] md:max-h-[400px] overflow-y-auto pr-4 custom-scrollbar">
                    {!! $section->content !!}
                </div>
            </div>

        <!-- Komponen Gambar & Teks -->
        @elseif($section->type == 'image_text')
            <div class="flex flex-col {{ $section->image_position == 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-8 md:gap-12 bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="w-full md:w-1/2">
                    @if($section->image)
                        <img src="{{ asset('storage/' . $section->image) }}" class="w-full rounded-2xl shadow-md object-cover h-64 md:h-[400px]" alt="{{ $section->title }}">
                    @endif
                </div>
                <div class="w-full md:w-1/2 space-y-6">
                    @if($section->title)
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $section->title }}</h2>
                    @endif
                    <!-- Membatasi ukuran kontainer teks agar tidak membesar mengikuti teks asli -->
                    <div class="prose prose-lg text-gray-600 max-h-[250px] overflow-y-auto pr-4 custom-scrollbar">
                        {!! $section->content !!}
                    </div>
                    @if($section->button_text)
                        <div class="pt-2">
                            <a href="{{ $section->button_link ?? '#' }}" class="inline-block px-8 py-3 bg-blue-600 text-white rounded-full font-bold hover:bg-blue-700 hover:shadow-lg transition transform hover:-translate-y-1">
                                {{ $section->button_text }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Komponen Video -->
        @elseif($section->type == 'video')
            <div class="max-w-4xl mx-auto">
                @if($section->title)
                    <h2 class="text-3xl font-bold text-center mb-6">{{ $section->title }}</h2>
                @endif
                @if($section->video_url)
                    @php
                        // Ekstrak ID Youtube jika memungkinkan untuk embed
                        $videoId = '';
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $section->video_url, $match);
                        if(isset($match[1])) {
                            $videoId = $match[1];
                        }
                    @endphp
                    
                    <div class="relative pt-[56.25%] rounded-2xl overflow-hidden shadow-xl bg-gray-900 border-4 border-white">
                        @if($videoId)
                            <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                            <!-- Fallback jika bukan URL youtube standar -->
                            <div class="absolute inset-0 flex items-center justify-center text-white">
                                <a href="{{ $section->video_url }}" target="_blank" class="px-6 py-3 bg-blue-600 rounded-lg font-bold hover:bg-blue-700 transition">Buka Video <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
        
    @endforeach
</div>

<!-- Section: Berita Terbaru (Tetap Statis di Bawah) -->
<div class="mb-12 border-t-2 border-gray-100 pt-10 md:pt-16">
    <div class="flex justify-between items-end mb-6 md:mb-8 pb-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Berita Terbaru</h2>
            <p class="text-gray-500 mt-1 md:mt-2 text-sm md:text-base">Kabar dan pembaruan terkini dari berbagai aktivitas komunitas.</p>
        </div>
        <a href="{{ route('news') }}" class="hidden sm:inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold transition group">
            Lihat Semua 
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
    
    <!-- Tombol mobile -->
    <div class="mt-6 text-center sm:hidden">
        <a href="{{ route('news') }}" class="inline-block w-full py-3 px-4 bg-blue-50 text-blue-700 font-bold rounded-lg hover:bg-blue-100 transition">
            Lihat Semua Berita
        </a>
    </div>
</div>
@endsection
