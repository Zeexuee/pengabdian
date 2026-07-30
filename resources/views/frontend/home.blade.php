@extends('layouts.app')

@section('title', 'Beranda Utama - Bank Sampah Sejahtera Gemilang RW. 06')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* =============================================
       SCROLLBAR CUSTOM & UTILITIES
    ============================================= */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Glassmorphism & Gradient Effects */
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .gradient-emerald-teal {
        background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
    }
    .gradient-hero-overlay {
        background: linear-gradient(to top, rgba(15, 23, 42, 0.85) 0%, rgba(15, 23, 42, 0.3) 60%, rgba(15, 23, 42, 0.1) 100%);
    }

    /* =============================================
       HERO SWIPER
    ============================================= */
    .hero-swiper { overflow: hidden; position: relative; background: #0f172a; }
    .hero-swiper .swiper-slide {
        width: 100% !important;
        height: 100%;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }
    .hero-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    .hero-swiper .swiper-pagination { bottom: 20px !important; }
    .hero-swiper .swiper-pagination-bullet {
        background: rgba(255,255,255,0.6); opacity: 1;
        width: 10px; height: 10px; transition: all 0.3s ease;
    }
    .hero-swiper .swiper-pagination-bullet-active {
        background: #10b981; width: 28px; border-radius: 6px;
    }

    /* =============================================
       CARD HOVER ANIMATIONS & SHADOWS
    ============================================= */
    .hover-lift {
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }
    
    .feature-card {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    .feature-card:hover {
        border-color: #a7f3d0;
        box-shadow: 0 12px 24px -6px rgba(16, 185, 129, 0.12);
    }

    /* =============================================
       SECTION WRAPPER
    ============================================= */
    .section-card {
        width: 100%;
        background: #ffffff;
        border-radius: 1.25rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        overflow: hidden;
    }

    /* =============================================
       DYNAMIC PAGE BUILDER COMPONENTS
    ============================================= */
    .img-cover-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 550px;
        overflow: hidden;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .img-cover-box img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
    }

    .text-content-box {
        max-height: 320px;
        overflow-y: auto;
        padding-right: 8px;
    }

    .img-text-img-box {
        width: 100%;
        height: 260px;
        overflow: hidden;
        border-radius: 1rem;
        background: #0f172a;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .img-text-img-box { height: 440px; }
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
        .img-text-content-box { max-height: 360px; }
    }

    .video-wrapper {
        position: relative;
        padding-top: 56.25%;
        border-radius: 1rem;
        overflow: hidden;
        background: #0f172a;
        border: 3px solid #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,.15);
    }
    .video-wrapper iframe,
    .video-wrapper .video-fallback {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
    }

    .section-title {
        font-size: clamp(1.25rem, 3vw, 1.75rem);
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
    }

    /* FAQ Accordion Styling */
    details summary::-webkit-details-marker { display: none; }
    details[open] summary .faq-icon { transform: rotate(180deg); }

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
                autoplay: { delay: 6000, disableOnInteraction: false },
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
     1. HERO BANNER — Full Width Modern Slider
=================================================== --}}
@section('full_width_content')
@if($hero_slides->count() > 0)
    <div class="relative w-full overflow-hidden">
        <div class="swiper hero-swiper w-full" style="height: clamp(280px, 58vw, 72vh);">
            <div class="swiper-wrapper">
                @foreach($hero_slides as $slide)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $slide->image) }}" alt="Hero Banner Bank Sampah">
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>

        {{-- Floating Badge Tagline Overlay --}}
        <div class="absolute top-4 left-4 sm:top-6 sm:left-8 z-10 pointer-events-none">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-900/80 text-emerald-400 backdrop-blur-md border border-emerald-500/30 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse mr-2"></span>
                Bank Sampah Sejahtera Gemilang RW. 06
            </span>
        </div>
    </div>
@else
    {{-- Fallback Default Banner jika belum ada slide dari admin --}}
    <div class="gradient-emerald-teal text-white py-16 px-4 text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto space-y-4">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 text-white text-xs font-semibold tracking-wide backdrop-blur">
                🌱 Peduli Lingkungan & Kelestarian RW. 06
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                Bank Sampah Sejahtera Gemilang
            </h1>
            <p class="text-emerald-100 text-base sm:text-lg max-w-2xl mx-auto">
                Mewujudkan Lingkungan Bersih, Sehat, dan Bernilai Ekonomi Melalui Pengelolaan Sampah Terpadu di RW. 006 Kelurahan Pakulonan Barat.
            </p>
            <div class="pt-4 flex flex-wrap justify-center gap-3">
                <a href="{{ route('join') }}" class="px-6 py-3 bg-white text-emerald-800 font-bold rounded-xl hover:bg-emerald-50 transition shadow-lg">
                    Bergabung Sekarang
                </a>
                <a href="{{ route('work_programs') }}" class="px-6 py-3 bg-emerald-700/60 hover:bg-emerald-700 text-white font-semibold rounded-xl backdrop-blur transition border border-white/20">
                    Lihat Program Kerja
                </a>
            </div>
        </div>
    </div>
@endif

{{-- Quick Info Bar Below Hero --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-emerald-50/60 transition group">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                ♻️
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Layanan Utama</p>
                <h4 class="text-xs sm:text-sm font-bold text-slate-900">Tabungan Sampah</h4>
            </div>
        </div>

        <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-teal-50/60 transition group">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                📅
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Jadwal Setor</p>
                <h4 class="text-xs sm:text-sm font-bold text-slate-900">Penimbangan Rutin</h4>
            </div>
        </div>

        <div class="flex items-center space-x-3 p-2 rounded-xl hover:bg-blue-50/60 transition group">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                📍
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Lokasi Posko</p>
                <h4 class="text-xs sm:text-sm font-bold text-slate-900">RW. 06 Pakulonan</h4>
            </div>
        </div>

        <a href="https://wa.me/6282114425126" target="_blank" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-green-50/60 transition group">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center font-bold text-xl group-hover:scale-110 transition-transform">
                💬
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Konsultasi WA</p>
                <h4 class="text-xs sm:text-sm font-bold text-emerald-700">Hubungi Langsung →</h4>
            </div>
        </a>
    </div>
</div>
@endsection

{{-- ===================================================
     2. KONTEN UTAMA LANDING PAGE
=================================================== --}}
@section('content')

<div class="space-y-12 sm:space-y-16 my-8 sm:my-12">

    {{-- -----------------------------------------------
         2.1 STATISTIK RINGKASAN DAMPAK
    ----------------------------------------------- --}}
    <div class="gradient-emerald-teal rounded-3xl p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="px-3 py-1 bg-white/20 rounded-full text-xs font-semibold uppercase tracking-wider text-emerald-100">
                    Statistik & Pencapaian
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold mt-2 text-white">Dampak Positif Bagi Lingkungan</h2>
                <p class="text-emerald-100 text-xs sm:text-sm mt-1">
                    Capaian bersama warga RW. 06 Pakulonan Barat dalam menciptakan kawasan hijau dan sejahtera.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/15">
                    <p class="text-3xl sm:text-4xl font-extrabold text-white">{{ $stats['programs'] ?? 0 }}</p>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium mt-1">Program Kerja</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/15">
                    <p class="text-3xl sm:text-4xl font-extrabold text-white">{{ $stats['products'] ?? 0 }}</p>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium mt-1">Produk Daur Ulang</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/15">
                    <p class="text-3xl sm:text-4xl font-extrabold text-white">{{ $stats['educations'] ?? 0 }}</p>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium mt-1">Artikel Edukasi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white/15">
                    <p class="text-3xl sm:text-4xl font-extrabold text-white">{{ $stats['members'] ?? 0 }}</p>
                    <p class="text-xs sm:text-sm text-emerald-100 font-medium mt-1">Pengurus & Anggota</p>
                </div>
            </div>
        </div>
    </div>


    {{-- -----------------------------------------------
         2.2 KEUNGGULAN & LAYANAN UTAMA (4 PILAR)
    ----------------------------------------------- --}}
    <div>
        <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                Layanan & Fitur Utama
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Mengapa Memilih Bank Sampah Kami?</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-2">
                Sistem pengelolaan sampah terintegrasi dari warga, oleh warga, dan untuk lingkungan sekitar.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Pilar 1 --}}
            <div class="bg-white rounded-2xl p-6 feature-card hover-lift">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-4 font-bold">
                    🗑️
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Pemilahan Sampah</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Panduan dan fasilitas pemilahan sampah organik, anorganik, dan daur ulang secara rapi sejak dari rumah tangga.
                </p>
            </div>

            {{-- Pilar 2 --}}
            <div class="bg-white rounded-2xl p-6 feature-card hover-lift">
                <div class="w-14 h-14 rounded-2xl bg-teal-100 text-teal-600 flex items-center justify-center text-2xl mb-4 font-bold">
                    💰
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Tabungan Sampah</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Ubah sampah anorganik yang disetor menjadi nilai ekonomi dan catatan tabungan nasabah yang transparan.
                </p>
            </div>

            {{-- Pilar 3 --}}
            <div class="bg-white rounded-2xl p-6 feature-card hover-lift">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-4 font-bold">
                    🎨
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Kreasi Daur Ulang</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Pengolahan sampah plastik dan limbah kreatif menjadi barang bernilai seni dan produk UMKM siap pakai.
                </p>
            </div>

            {{-- Pilar 4 --}}
            <div class="bg-white rounded-2xl p-6 feature-card hover-lift">
                <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-4 font-bold">
                    📚
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2">Edukasi & Pelatihan</h3>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                    Sosialisasi berkala, workshop pengomposan, serta pelatihan pengurusan lingkungan bagi seluruh warga.
                </p>
            </div>
        </div>
    </div>


    {{-- -----------------------------------------------
         2.3 PROGRAM KERJA UNGGULAN
    ----------------------------------------------- --}}
    @if(isset($featured_programs) && $featured_programs->count() > 0)
    <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-10 shadow-xl">
        <div class="flex flex-wrap justify-between items-end mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400 bg-emerald-950/80 px-3 py-1 rounded-full border border-emerald-800">
                    Aktivitas & Inisiatif
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Program Kerja Utama</h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-1">
                    Inisiatif nyata yang dirancang dan dijalankan secara berkelanjutan oleh pengurus.
                </p>
            </div>
            <a href="{{ route('work_programs') }}" class="inline-flex items-center text-emerald-400 hover:text-emerald-300 font-semibold text-xs sm:text-sm transition">
                Lihat Semua Program →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured_programs as $prog)
                <div class="bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-700/60 flex flex-col hover:border-emerald-500/50 transition duration-300">
                    @if($prog->thumbnail)
                        <div class="h-44 overflow-hidden bg-slate-950">
                            <img src="{{ asset('storage/' . $prog->thumbnail) }}" alt="{{ $prog->title }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                    @else
                        <div class="h-44 bg-slate-950 flex items-center justify-center text-slate-600">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    @endif
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="font-bold text-base sm:text-lg text-white mb-2 line-clamp-2">
                            {{ $prog->title }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-400 mb-4 line-clamp-3 flex-grow">
                            {{ Str::limit(strip_tags($prog->description), 100) }}
                        </p>
                        <a href="{{ route('work_programs.detail', $prog->id) }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:underline mt-auto">
                            Detail Program
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif


    {{-- -----------------------------------------------
         2.4 SHOWCASE PRODUK DAUR ULANG UNGGULAN
    ----------------------------------------------- --}}
    @if(isset($featured_products) && $featured_products->count() > 0)
    <div>
        <div class="flex flex-wrap justify-between items-end mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                    Karya & Olahan Daur Ulang
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 mt-2">Produk Unggulan Bank Sampah</h2>
                <p class="text-slate-500 text-sm sm:text-base mt-1">
                    Koleksi produk kreatif ramah lingkungan yang dibuat dari sampah terolah.
                </p>
            </div>
            <a href="{{ route('products') }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-bold text-sm transition">
                Katalog Produk Lengkap →
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($featured_products as $prod)
                @php
                    $primaryImg = $prod->images->first() ? asset('storage/' . $prod->images->first()->image_path) : null;
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover-lift flex flex-col overflow-hidden group">
                    <div class="aspect-square overflow-hidden bg-slate-100 relative">
                        @if($primaryImg)
                            <img src="{{ $primaryImg }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-300">
                                🖼️ No Image
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 bg-emerald-600 text-white text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded-md shadow">
                            Ramah Lingkungan
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-xs sm:text-sm text-slate-900 mb-1 group-hover:text-emerald-600 transition line-clamp-2">
                            {{ $prod->name }}
                        </h3>
                        @if($prod->price)
                            <p class="text-xs sm:text-sm font-extrabold text-emerald-600 mb-3">
                                Rp {{ number_format($prod->price, 0, ',', '.') }}
                            </p>
                        @endif

                        <div class="mt-auto pt-2 flex items-center justify-between gap-2">
                            <a href="{{ route('products.detail', $prod->slug) }}" class="w-full text-center py-2 px-3 bg-slate-100 hover:bg-emerald-600 hover:text-white text-slate-700 text-xs font-bold rounded-xl transition">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif


    {{-- -----------------------------------------------
         2.5 DYNAMIC PAGE BUILDER SECTIONS (ADMIN)
    ----------------------------------------------- --}}
    @if(isset($sections) && $sections->count() > 0)
    <div class="space-y-8 sm:space-y-10">
        @foreach($sections as $section)

            {{-- GAMBAR TUNGGAL --}}
            @if($section->type == 'image')
                <div class="section-card">
                    @if($section->title)
                        <div class="px-5 pt-6 pb-3 md:px-8 md:pt-8 md:pb-4 border-b border-slate-100">
                            <h2 class="section-title">{{ $section->title }}</h2>
                        </div>
                    @endif
                    @if($section->image)
                        <div class="img-cover-box">
                            <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Gambar' }}">
                        </div>
                    @endif
                </div>

            {{-- TEKS --}}
            @elseif($section->type == 'text')
                <div class="section-card px-6 py-8 md:px-10 md:py-10 max-w-4xl mx-auto">
                    @if($section->title)
                        <h2 class="section-title mb-4 border-b pb-3 border-slate-100">{{ $section->title }}</h2>
                    @endif
                    <div class="text-content-box prose prose-sm md:prose-base prose-emerald max-w-none text-slate-600 custom-scrollbar">
                        {!! $section->content !!}
                    </div>
                </div>

            {{-- GAMBAR + TEKS --}}
            @elseif($section->type == 'image_text')
                <div class="section-card">
                    <div class="flex flex-col {{ $section->image_position == 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} items-stretch gap-0">
                        <div class="w-full md:w-1/2 p-4 md:p-6 flex items-center">
                            @if($section->image)
                                <div class="img-text-img-box w-full shadow-inner">
                                    <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Gambar' }}">
                                </div>
                            @endif
                        </div>
                        <div class="w-full md:w-1/2 p-6 md:p-10 flex flex-col justify-center space-y-4">
                            @if($section->title)
                                <h2 class="section-title text-slate-900">{{ $section->title }}</h2>
                            @endif
                            <div class="img-text-content-box prose prose-sm md:prose-base prose-emerald text-slate-600 max-w-none custom-scrollbar">
                                {!! $section->content !!}
                            </div>
                            @if($section->button_text)
                                <div class="pt-2">
                                    <a href="{{ $section->button_link ?? '#' }}" class="inline-block px-7 py-3 bg-emerald-600 text-white text-xs sm:text-sm font-bold rounded-xl hover:bg-emerald-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                                        {{ $section->button_text }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- VIDEO --}}
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
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <div class="video-fallback flex items-center justify-center">
                                    <a href="{{ $section->video_url }}" target="_blank" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">
                                        Buka Video
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
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
    @endif


    {{-- -----------------------------------------------
         2.6 EDUKASI & TIPS LINGKUNGAN (HIGHLIGHT)
    ----------------------------------------------- --}}
    @if(isset($featured_educations) && $featured_educations->count() > 0)
    <div class="bg-emerald-50/60 rounded-3xl p-6 sm:p-10 border border-emerald-100">
        <div class="flex flex-wrap justify-between items-end mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-white px-3 py-1 rounded-full shadow-sm">
                    Edukasi & Pemilahan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Tips & Edukasi Lingkungan</h2>
                <p class="text-slate-600 text-xs sm:text-sm mt-1">
                    Panduan praktis memilah sampah dan menjaga kebersihan lingkungan rumah tangga.
                </p>
            </div>
            <a href="{{ route('educations') }}" class="inline-flex items-center text-emerald-700 hover:text-emerald-800 font-bold text-xs sm:text-sm transition">
                Semua Artikel Edukasi →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($featured_educations as $edu)
                <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm hover-lift flex flex-col">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 w-max px-2.5 py-1 rounded-md mb-3">
                        Artikel Edukasi
                    </span>
                    <h3 class="font-bold text-base text-slate-900 mb-2 line-clamp-2 hover:text-emerald-600 transition">
                        {{ $edu->title }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 line-clamp-3 flex-grow">
                        {{ Str::limit(strip_tags($edu->content ?? ''), 95) }}
                    </p>
                    <a href="{{ route('educations.detail', $edu->slug) }}" class="inline-flex items-center text-xs font-bold text-emerald-600 hover:underline mt-auto">
                        Baca Selengkapnya
                        <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @endif


    {{-- -----------------------------------------------
         2.7 BERITA TERBARU
    ----------------------------------------------- --}}
    <div class="pt-4">
        <div class="flex flex-wrap justify-between items-end mb-6 sm:mb-8 gap-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    Kabar Terkini
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Berita & Informasi Kegiatan</h2>
                <p class="text-slate-500 text-xs sm:text-sm mt-1">Kabar dan update kegiatan terbaru dari komunitas Bank Sampah RW. 06.</p>
            </div>
            <a href="{{ route('news') }}" class="hidden sm:inline-flex items-center text-emerald-600 hover:text-emerald-700 font-bold text-sm transition">
                Lihat Semua Berita
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($latest_news as $item)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover-lift flex flex-col overflow-hidden group">
                    <div class="h-48 overflow-hidden bg-slate-900 relative">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-slate-400 bg-slate-100">
                                📰 Berita
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 bg-white/95 backdrop-blur px-2.5 py-1 rounded-full text-[10px] font-bold text-emerald-700 shadow-sm">
                            Terbaru
                        </div>
                    </div>

                    <div class="p-5 flex flex-col flex-grow">
                        <p class="text-[11px] text-slate-400 mb-2 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $item->published_at ? $item->published_at->format('d M Y') : 'Hari ini' }}
                        </p>

                        <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-emerald-600 transition line-clamp-2">
                            {{ $item->title }}
                        </h3>

                        <p class="text-slate-500 text-xs sm:text-sm mb-4 line-clamp-3 flex-grow leading-relaxed">
                            {!! Str::limit(strip_tags($item->content), 110) !!}
                        </p>

                        <a href="{{ route('news.detail', $item->slug) }}" class="inline-flex items-center text-emerald-600 text-xs sm:text-sm font-bold hover:underline mt-auto">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <p class="text-slate-400 font-medium text-sm">Belum ada rilis berita terbaru.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6 text-center sm:hidden">
            <a href="{{ route('news') }}" class="inline-block w-full py-3 px-4 bg-emerald-50 text-emerald-700 font-bold rounded-xl text-sm">
                Lihat Semua Berita →
            </a>
        </div>
    </div>


    {{-- -----------------------------------------------
         2.8 INTERACTIVE FAQ ACCORDION
    ----------------------------------------------- --}}
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-100 shadow-sm max-w-4xl mx-auto">
        <div class="text-center mb-8">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-600 bg-teal-50 px-3 py-1 rounded-full">
                Pertanyaan Umum
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-2">Pertanyaan Sering Diajukan (FAQ)</h2>
            <p class="text-slate-500 text-xs sm:text-sm mt-1">Informasi penting terkait pendaftaran nasabah dan cara kerja Bank Sampah.</p>
        </div>

        <div class="space-y-4">
            <details class="group bg-slate-50 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden border border-slate-200/60">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-slate-900 font-bold text-sm sm:text-base">
                    <span>Bagaimana cara mendaftar sebagai Nasabah Bank Sampah?</span>
                    <span class="shrink-0 rounded-full bg-white p-1.5 text-slate-900 shadow-sm faq-icon transition duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </summary>
                <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                    Anda dapat mendaftar langsung secara online melalui menu <a href="{{ route('join') }}" class="text-emerald-600 font-bold underline">Bergabung / Formulir Kontak</a> di website ini, atau langsung mengunjungi lokasi posko Bank Sampah RW. 06 pada saat jadwal penimbangan sampah.
                </p>
            </details>

            <details class="group bg-slate-50 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden border border-slate-200/60">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-slate-900 font-bold text-sm sm:text-base">
                    <span>Jenis sampah apa saja yang dapat ditabung/disetorkan?</span>
                    <span class="shrink-0 rounded-full bg-white p-1.5 text-slate-900 shadow-sm faq-icon transition duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </summary>
                <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                    Kami menerima sampah anorganik yang sudah dipilah dan dibersihkan, seperti botol/gelas plastik, kertas/kardus bekas, kaleng/logam, dan minyak jelantah.
                </p>
            </details>

            <details class="group bg-slate-50 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden border border-slate-200/60">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-slate-900 font-bold text-sm sm:text-base">
                    <span>Kapan jadwal operasional penimbangan sampah dilaksanakan?</span>
                    <span class="shrink-0 rounded-full bg-white p-1.5 text-slate-900 shadow-sm faq-icon transition duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </summary>
                <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                    Jadwal penimbangan rutin dilaksanakan sesuai pengumuman pengurus di kawasan RW. 06 Pakulonan Barat. Informasi lebih detail dapat dikonfirmasikan via kontak WhatsApp pengurus.
                </p>
            </details>

            <details class="group bg-slate-50 rounded-2xl p-4 sm:p-5 [&_summary::-webkit-details-marker]:hidden border border-slate-200/60">
                <summary class="flex cursor-pointer items-center justify-between gap-1.5 text-slate-900 font-bold text-sm sm:text-base">
                    <span>Bagaimana cara memesan produk hasil daur ulang Bank Sampah?</span>
                    <span class="shrink-0 rounded-full bg-white p-1.5 text-slate-900 shadow-sm faq-icon transition duration-300">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </span>
                </summary>
                <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3">
                    Anda dapat melihat katalog produk pada menu <a href="{{ route('products') }}" class="text-emerald-600 font-bold underline">Produk Kami</a>, lalu menekan tombol pemesanan untuk terhubung dengan pengurus via WhatsApp.
                </p>
            </details>
        </div>
    </div>


    {{-- -----------------------------------------------
         2.9 CALL TO ACTION BANNER (AJAKAN BERGABUNG)
    ----------------------------------------------- --}}
    <div class="gradient-emerald-teal rounded-3xl p-8 sm:p-12 text-white text-center shadow-2xl relative overflow-hidden">
        <div class="max-w-3xl mx-auto space-y-4 relative z-10">
            <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 text-emerald-100 text-xs font-bold uppercase tracking-wider backdrop-blur">
                🌱 Bersama Menjaga Bumi
            </span>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight">
                Mari Wujudkan RW. 06 Bersih, Hijau, dan Sejahtera!
            </h2>
            <p class="text-emerald-100 text-xs sm:text-base max-w-xl mx-auto leading-relaxed">
                Jadilah bagian dari gerakan kepedulian lingkungan. Kelola sampah rumah tangga Anda secara bijak bersama Bank Sampah Sejahtera Gemilang.
            </p>
            <div class="pt-4 flex flex-wrap justify-center gap-4">
                <a href="{{ route('join') }}" class="px-8 py-3.5 bg-white text-emerald-900 font-extrabold rounded-2xl hover:bg-emerald-50 transition shadow-lg text-xs sm:text-sm transform hover:-translate-y-0.5">
                    Daftar Nasabah / Relawan
                </a>
                <a href="https://wa.me/6282114425126" target="_blank" class="px-8 py-3.5 bg-slate-900/80 hover:bg-slate-900 text-white font-extrabold rounded-2xl border border-white/20 transition shadow-lg text-xs sm:text-sm transform hover:-translate-y-0.5">
                    Hubungi Pengurus via WA
                </a>
            </div>
        </div>
    </div>

</div>

@endsection
