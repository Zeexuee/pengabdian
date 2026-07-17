@extends('layouts.app')

@section('title', 'Beranda Utama')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* =============================================
       SCROLLBAR CUSTOM
    ============================================= */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* =============================================
       HERO SWIPER
    ============================================= */
    .hero-swiper { overflow: hidden; position: relative; background: #1e293b; }
    .hero-swiper .swiper-slide {
        width: 100% !important;
        height: 100%;
        background: #1e293b;        /* letterbox area di setiap slide */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;        /* gambar penuh, tidak terpotong */
        display: block;
    }
    .hero-swiper .swiper-pagination { bottom: 16px !important; }
    .hero-swiper .swiper-pagination-bullet {
        background: rgba(255,255,255,0.7); opacity: 1;
        width: 10px; height: 10px; transition: all 0.3s ease;
    }
    .hero-swiper .swiper-pagination-bullet-active {
        background: #2563eb; width: 24px; border-radius: 5px;
    }

    /* =============================================
       SECTION WRAPPER — batas lebar + padding konsisten
    ============================================= */
    .section-card {
        width: 100%;
        background: #ffffff;
        border-radius: 1.25rem;       /* 20px */
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        overflow: hidden;
    }

    /* =============================================
       IMAGE COMPONENT — gambar tampil penuh (contain)
    ============================================= */
    .img-cover-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 600px;
        overflow: hidden;
        /* background abu gelap agar area kosong (letterbox) terlihat rapi */
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .img-cover-box img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
    }

    /* =============================================
       TEXT COMPONENT — konten bisa di-scroll jika terlalu panjang
    ============================================= */
    .text-content-box {
        max-height: 320px;
        overflow-y: auto;
        padding-right: 8px;
    }

    /* =============================================
       IMAGE+TEXT COMPONENT — tinggi gambar dikunci
    ============================================= */
    .img-text-img-box {
        width: 100%;
        height: 260px;
        overflow: hidden;
        border-radius: 1rem;
        /* background gelap agar area kosong rapi */
        background: #1e293b;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .img-text-img-box { height: 460px; }
    }
    .img-text-img-box img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
    }
    .img-text-content-box {
        max-height: 220px;
        overflow-y: auto;
        padding-right: 6px;
    }
    @media (min-width: 768px) {
        .img-text-content-box { max-height: 380px; }
    }

    /* =============================================
       VIDEO COMPONENT — responsif aspect ratio
    ============================================= */
    .video-wrapper {
        position: relative;
        padding-top: 56.25%;            /* 16:9 */
        border-radius: 1rem;
        overflow: hidden;
        background: #1e293b;
        border: 3px solid #ffffff;
        box-shadow: 0 8px 32px rgba(0,0,0,.18);
    }
    .video-wrapper iframe,
    .video-wrapper .video-fallback {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
    }

    /* =============================================
       SECTION TITLE — ukuran teks konsisten
    ============================================= */
    .section-title {
        font-size: clamp(1.25rem, 3vw, 1.75rem);
        font-weight: 700;
        color: #111827;
        line-height: 1.3;
        /* batasi panjang judul agar tidak wrap terlalu banyak */
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* =============================================
       NEWS CARD — tinggi gambar dikunci
    ============================================= */
    .news-thumb {
        height: 140px; /* lebih pendek di mobile karena 2 kolom */
        overflow: hidden;
        background: #1e293b;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 640px) {
        .news-thumb { height: 200px; }
    }
    .news-thumb img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
        transition: transform .5s ease;
    }
    .news-card:hover .news-thumb img { transform: scale(1.05); }

    /* =============================================
       GLOBAL — hindari overflow horizontal di mobile
    ============================================= */
    * { box-sizing: border-box; }
    body { overflow-x: hidden; }
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
                autoplay: { delay: 10000, disableOnInteraction: false },
                effect: 'fade',
                fadeEffect: { crossFade: true },
                pagination: { el: '.swiper-pagination', clickable: true },
                speed: 1000,
            });
        }
    });
</script>
@endpush

{{-- ===================================================
     HERO BANNER — full width, dikunci 70vh / min 240px
=================================================== --}}
@section('full_width_content')
@if($hero_slides->count() > 0)
    <div class="swiper hero-swiper w-full" style="height: clamp(240px, 55vw, 70vh);">
        <div class="swiper-wrapper">
            @foreach($hero_slides as $slide)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $slide->image) }}"
                         alt="Hero Banner">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
@endif
@endsection

{{-- ===================================================
     KONTEN UTAMA
=================================================== --}}
@section('content')

<div class="space-y-10 md:space-y-14 mb-16">

    @foreach($sections as $section)

        {{-- -----------------------------------------------
             KOMPONEN: GAMBAR TUNGGAL
        ----------------------------------------------- --}}
        @if($section->type == 'image')
            <div class="section-card">
                @if($section->title)
                    <div class="px-5 pt-6 pb-3 md:px-8 md:pt-8 md:pb-4">
                        <h2 class="section-title">{{ $section->title }}</h2>
                    </div>
                @endif
                @if($section->image)
                    <div class="img-cover-box {{ $section->title ? '' : 'rounded-t-[1.25rem]' }}">
                        <img src="{{ asset('storage/' . $section->image) }}"
                             alt="{{ $section->title ?? 'Gambar' }}">
                    </div>
                @endif
            </div>

        {{-- -----------------------------------------------
             KOMPONEN: TEKS
        ----------------------------------------------- --}}
        @elseif($section->type == 'text')
            <div class="section-card px-5 py-6 md:px-8 md:py-8 max-w-4xl mx-auto">
                @if($section->title)
                    <h2 class="section-title mb-4">{{ $section->title }}</h2>
                @endif
                <div class="text-content-box prose prose-sm md:prose-base prose-red max-w-none text-gray-600 custom-scrollbar">
                    {!! $section->content !!}
                </div>
            </div>

        {{-- -----------------------------------------------
             KOMPONEN: GAMBAR + TEKS
        ----------------------------------------------- --}}
        @elseif($section->type == 'image_text')
            <div class="section-card">
                <div class="flex flex-col {{ $section->image_position == 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} items-stretch gap-0">

                    {{-- Gambar --}}
                    <div class="w-full md:w-1/2 p-4 md:p-6 flex items-center">
                        @if($section->image)
                            <div class="img-text-img-box w-full">
                                <img src="{{ asset('storage/' . $section->image) }}"
                                     alt="{{ $section->title ?? 'Gambar' }}">
                            </div>
                        @endif
                    </div>

                    {{-- Teks --}}
                    <div class="w-full md:w-1/2 p-5 md:p-8 flex flex-col justify-center space-y-4">
                        @if($section->title)
                            <h2 class="section-title">{{ $section->title }}</h2>
                        @endif
                        <div class="img-text-content-box prose prose-sm md:prose-base prose-red text-gray-600 max-w-none custom-scrollbar">
                            {!! $section->content !!}
                        </div>
                        @if($section->button_text)
                            <div class="pt-2">
                                <a href="{{ $section->button_link ?? '#' }}"
                                   class="inline-block px-7 py-3 bg-red-600 text-white text-sm font-bold rounded-full hover:bg-red-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                                    {{ $section->button_text }}
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        {{-- -----------------------------------------------
             KOMPONEN: VIDEO
        ----------------------------------------------- --}}
        @elseif($section->type == 'video')
            <div class="section-card px-5 py-6 md:px-8 md:py-8 max-w-4xl mx-auto">
                @if($section->title)
                    <h2 class="section-title text-center mb-5">{{ $section->title }}</h2>
                @endif
                @if($section->video_url)
                    @php
                        $videoId = '';
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $section->video_url, $match);
                        if(isset($match[1])) { $videoId = $match[1]; }
                    @endphp
                    <div class="video-wrapper">
                        @if($videoId)
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        @else
                            <div class="video-fallback flex items-center justify-center">
                                <a href="{{ $section->video_url }}" target="_blank"
                                   class="px-6 py-3 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition">
                                    Buka Video
                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

        @endif

    @endforeach

</div>

{{-- ===================================================
     SECTION BERITA TERBARU
=================================================== --}}
<div class="mb-12 border-t-2 border-gray-100 pt-10 md:pt-14">

    {{-- Header --}}
    <div class="flex flex-wrap justify-between items-end mb-6 md:mb-8 gap-2">
        <div class="min-w-0">
            <h2 class="text-xl md:text-3xl font-bold text-gray-900 truncate">Berita Terbaru</h2>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Kabar dan pembaruan terkini dari berbagai aktivitas komunitas.</p>
        </div>
        <a href="{{ route('news') }}"
           class="hidden sm:inline-flex items-center text-red-600 hover:text-red-800 font-semibold transition group flex-shrink-0">
            Lihat Semua
            <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>

    {{-- Grid Kartu Berita --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
        @forelse($latest_news as $item)
            <div class="news-card bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">

                {{-- Thumbnail — tinggi dikunci --}}
                <div class="news-thumb">
                    @if($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                             alt="{{ $item->title }}">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-300 bg-gray-100">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="absolute top-3 right-3 bg-white/95 backdrop-blur px-2.5 py-1 rounded-full text-xs font-bold text-red-600 shadow-sm">
                        Baru
                    </div>
                </div>

                {{-- Konten Kartu --}}
                <div class="p-5 flex flex-col flex-grow">
                    <p class="text-[10px] sm:text-xs text-gray-400 mb-1 sm:mb-2 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $item->published_at ? $item->published_at->format('d M Y') : 'Hari ini' }}
                    </p>

                    {{-- Judul — max 2 baris --}}
                    <h3 class="text-sm sm:text-base font-bold text-gray-900 mb-1 sm:mb-2 group-hover:text-red-600 transition line-clamp-2 leading-snug">
                        {{ $item->title }}
                    </h3>

                    {{-- Excerpt — max 3 baris --}}
                    <p class="text-gray-500 text-xs sm:text-sm mb-3 sm:mb-4 line-clamp-3 flex-grow">
                        {!! Str::limit(strip_tags($item->content), 110) !!}
                    </p>

                    <a href="{{ route('news.detail', $item->slug) }}"
                       class="inline-flex items-center text-red-600 text-[11px] sm:text-sm font-semibold hover:underline mt-auto">
                        Baca Selengkapnya
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-gray-400 font-medium">Belum ada rilis berita terbaru untuk saat ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Tombol "Lihat Semua" versi mobile --}}
    <div class="mt-6 text-center sm:hidden">
        <a href="{{ route('news') }}"
           class="inline-block w-full py-3 px-4 bg-red-50 text-red-700 font-bold rounded-xl hover:bg-red-100 transition text-sm">
            Lihat Semua Berita →
        </a>
    </div>

</div>

@endsection
