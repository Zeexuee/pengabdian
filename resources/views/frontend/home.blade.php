@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Hero Swiper */
    .hero-swiper { overflow: hidden; position: relative; background: #0f172a; border-radius: 1rem; }
    .hero-swiper .swiper-slide {
        width: 100% !important;
        height: 100%;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-swiper .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    .hero-swiper .swiper-pagination { bottom: 16px !important; }
    .hero-swiper .swiper-pagination-bullet {
        background: rgba(255,255,255,0.5); opacity: 1;
        width: 8px; height: 8px; transition: all 0.3s ease;
    }
    .hero-swiper .swiper-pagination-bullet-active {
        background: #10b981; width: 20px; border-radius: 4px;
    }

    /* Clean Card Hover */
    .clean-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .clean-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }

    /* Page Builder Media Containers */
    .builder-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 520px;
        overflow: hidden;
        background: #0f172a;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .builder-img-box img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
    }

    .builder-img-text-img {
        width: 100%;
        height: 240px;
        overflow: hidden;
        border-radius: 0.75rem;
        background: #0f172a;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .builder-img-text-img { height: 400px; }
    }
    .builder-img-text-img img {
        width: 100%; height: 100%;
        object-fit: contain; display: block;
    }

    .builder-video-wrapper {
        position: relative;
        padding-top: 56.25%;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #0f172a;
    }
    .builder-video-wrapper iframe,
    .builder-video-wrapper .video-fallback {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
    }

    .scroll-content {
        max-height: 320px;
        overflow-y: auto;
    }

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
                speed: 800,
            });
        }
    });
</script>
@endpush

@section('content')

<div class="space-y-14 sm:space-y-20 py-4">

    @if(isset($sections) && $sections->count() > 0)
        @foreach($sections as $section)

            {{-- -----------------------------------------------
                 HERO SLIDER BANNER
            ----------------------------------------------- --}}
            @if($section->type == 'hero')
                @if(isset($hero_slides) && $hero_slides->count() > 0)
                    <div class="swiper hero-swiper w-full" style="height: clamp(260px, 50vw, 550px);">
                        <div class="swiper-wrapper">
                            @foreach($hero_slides as $slide)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="Hero Banner">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-slate-200/80 p-8 sm:p-12 text-center max-w-4xl mx-auto space-y-3">
                        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                            Bank Sampah Sejahtera Gemilang
                        </h1>
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
                            Informasi kegiatan, program kerja, edukasi lingkungan, dan produk daur ulang Bank Sampah Sejahtera Gemilang RW. 006 Kelurahan Pakulonan Barat.
                        </p>
                    </div>
                @endif

            {{-- -----------------------------------------------
                 SYSTEM: PROGRAM KERJA HIGHLIGHT
            ----------------------------------------------- --}}
            @elseif($section->type == 'system_program_kerja')
                @if(isset($featured_programs) && $featured_programs->count() > 0)
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $section->title ?: 'Program Kerja' }}</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">program-program dan kegiatan RW.006 Pakulonan Barat.</p>
                        </div>
                        <a href="{{ route('work_programs') }}" class="text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($featured_programs as $prog)
                            <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden clean-card flex flex-col">
                                @if($prog->thumbnail)
                                    <div class="h-44 overflow-hidden bg-slate-100">
                                        <img src="{{ asset('storage/' . $prog->thumbnail) }}" alt="{{ $prog->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="p-5 flex flex-col flex-grow">
                                    <h3 class="font-bold text-slate-900 text-base mb-2 line-clamp-2">
                                        {{ $prog->title }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-500 mb-4 line-clamp-3 leading-relaxed flex-grow">
                                        {{ Str::limit(strip_tags($prog->description), 110) }}
                                    </p>
                                    <a href="{{ route('work_programs.detail', $prog->id) }}" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:underline mt-auto">
                                        Baca Rincian Program →
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            {{-- -----------------------------------------------
                 SYSTEM: PRODUK DAUR ULANG HIGHLIGHT
            ----------------------------------------------- --}}
            @elseif($section->type == 'system_produk')
                @if(isset($featured_products) && $featured_products->count() > 0)
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $section->title ?: 'Produk Daur Ulang' }}</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Karya dan produk hasil olahan sampah organik/anorganik.</p>
                        </div>
                        <a href="{{ route('products') }}" class="text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                            Katalog Lengkap →
                        </a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($featured_products as $prod)
                            @php
                                $img = $prod->images->first() ? asset('storage/' . $prod->images->first()->image_path) : null;
                            @endphp
                            <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden clean-card flex flex-col">
                                <div class="aspect-square bg-slate-100 overflow-hidden">
                                    @if($img)
                                        <img src="{{ $img }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">
                                            Tanpa Foto
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="font-bold text-xs sm:text-sm text-slate-900 mb-1 line-clamp-2">
                                        {{ $prod->name }}
                                    </h3>
                                    @if($prod->price)
                                        <p class="text-xs sm:text-sm font-semibold text-emerald-700 mb-3">
                                            Rp {{ number_format($prod->price, 0, ',', '.') }}
                                        </p>
                                    @endif
                                    <a href="{{ route('products.detail', $prod->slug) }}" class="mt-auto block text-center py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            {{-- -----------------------------------------------
                 SYSTEM: EDUKASI LINGKUNGAN HIGHLIGHT
            ----------------------------------------------- --}}
            @elseif($section->type == 'system_edukasi')
                @if(isset($featured_educations) && $featured_educations->count() > 0)
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $section->title ?: 'Edukasi Lingkungan' }}</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Artikel dan informasi seputar pemilahan sampah & kelestarian.</p>
                        </div>
                        <a href="{{ route('educations') }}" class="text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                            Semua Edukasi →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($featured_educations as $edu)
                            <div class="bg-white rounded-xl border border-slate-200/80 p-5 clean-card flex flex-col">
                                <h3 class="font-bold text-slate-900 text-base mb-2 line-clamp-2">
                                    {{ $edu->title }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 mb-4 line-clamp-3 leading-relaxed flex-grow">
                                    {{ Str::limit(strip_tags($edu->content ?? ''), 100) }}
                                </p>
                                <a href="{{ route('educations.detail', $edu->slug) }}" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:underline mt-auto">
                                    Baca Artikel →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            {{-- -----------------------------------------------
                 SYSTEM: BERITA TERBARU HIGHLIGHT
            ----------------------------------------------- --}}
            @elseif($section->type == 'system_berita')
                <div>
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">{{ $section->title ?: 'Berita Terbaru' }}</h2>
                            <p class="text-xs sm:text-sm text-slate-500 mt-1">Publikasi dan warta kegiatan Bank Sampah Sejahtera Gemilang RW.006 Pakulonan Barat.</p>
                        </div>
                        <a href="{{ route('news') }}" class="text-xs sm:text-sm font-semibold text-emerald-700 hover:text-emerald-800 transition">
                            Arsip Berita →
                        </a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($latest_news as $item)
                            <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden clean-card flex flex-col">
                                @if($item->thumbnail)
                                    <div class="h-44 overflow-hidden bg-slate-100">
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="p-5 flex flex-col flex-grow">
                                    <p class="text-[11px] text-slate-400 mb-2 font-medium">
                                        {{ $item->published_at ? $item->published_at->format('d M Y') : 'Hari ini' }}
                                    </p>
                                    <h3 class="font-bold text-slate-900 text-base mb-2 line-clamp-2">
                                        {{ $item->title }}
                                    </h3>
                                    <p class="text-xs sm:text-sm text-slate-500 mb-4 line-clamp-3 leading-relaxed flex-grow">
                                        {!! Str::limit(strip_tags($item->content), 105) !!}
                                    </p>
                                    <a href="{{ route('news.detail', $item->slug) }}" class="inline-flex items-center text-xs font-semibold text-emerald-700 hover:underline mt-auto">
                                        Baca Selengkapnya →
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-10 text-center bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                <p class="text-slate-400 text-xs sm:text-sm">Belum ada berita yang dipublikasikan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: GAMBAR
            ----------------------------------------------- --}}
            @elseif($section->type == 'image')
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden p-4 sm:p-6">
                    @if($section->title)
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-4">{{ $section->title }}</h2>
                    @endif
                    @if($section->image)
                        <div class="builder-img-box">
                            <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Gambar' }}">
                        </div>
                    @endif
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: TEKS
            ----------------------------------------------- --}}
            @elseif($section->type == 'text')
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-10 max-w-4xl mx-auto">
                    @if($section->title)
                        <h2 class="text-lg sm:text-2xl font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">{{ $section->title }}</h2>
                    @endif
                    <div class="scroll-content prose prose-sm sm:prose-base max-w-none text-slate-700 custom-scrollbar leading-relaxed">
                        {!! $section->content !!}
                    </div>
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: GAMBAR + TEKS
            ----------------------------------------------- --}}
            @elseif($section->type == 'image_text')
                <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden p-4 sm:p-6">
                    <div class="flex flex-col {{ $section->image_position == 'right' ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-6 sm:gap-8">
                        <div class="w-full md:w-1/2">
                            @if($section->image)
                                <div class="builder-img-text-img">
                                    <img src="{{ asset('storage/' . $section->image) }}" alt="{{ $section->title ?? 'Gambar' }}">
                                </div>
                            @endif
                        </div>
                        <div class="w-full md:w-1/2 space-y-4">
                            @if($section->title)
                                <h2 class="text-lg sm:text-2xl font-bold text-slate-900">{{ $section->title }}</h2>
                            @endif
                            <div class="scroll-content prose prose-sm sm:prose-base max-w-none text-slate-600 custom-scrollbar leading-relaxed">
                                {!! $section->content !!}
                            </div>
                            @if($section->button_text)
                                <div class="pt-2">
                                    <a href="{{ $section->button_link ?? '#' }}" class="inline-block px-6 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-semibold rounded-lg transition">
                                        {{ $section->button_text }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: VIDEO
            ----------------------------------------------- --}}
            @elseif($section->type == 'video')
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 max-w-4xl mx-auto">
                    @if($section->title)
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900 text-center mb-6">{{ $section->title }}</h2>
                    @endif
                    @if($section->video_url)
                        @php
                            $videoId = '';
                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $section->video_url, $match);
                            if(isset($match[1])) { $videoId = $match[1]; }
                        @endphp
                        <div class="builder-video-wrapper">
                            @if($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @else
                                <div class="video-fallback flex items-center justify-center bg-slate-900 text-white">
                                    <a href="{{ $section->video_url }}" target="_blank" class="px-5 py-2.5 bg-emerald-700 text-white rounded-lg text-sm font-medium hover:bg-emerald-800 transition">
                                        Tonton Video →
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: BANNER PENGUMUMAN / CALLOUT
            ----------------------------------------------- --}}
            @elseif($section->type == 'callout')
                <div class="bg-emerald-50/90 rounded-2xl border border-emerald-200/80 p-6 sm:p-8 max-w-4xl mx-auto shadow-sm">
                    @if($section->title)
                        <h2 class="text-lg sm:text-xl font-bold text-emerald-950 mb-3 flex items-center gap-2">
                            <span>📌</span> {{ $section->title }}
                        </h2>
                    @endif
                    <div class="prose prose-sm sm:prose-base prose-emerald max-w-none text-emerald-900 leading-relaxed mb-4">
                        {!! $section->content !!}
                    </div>
                    @if($section->button_text)
                        <div>
                            <a href="{{ $section->button_link ?? '#' }}" class="inline-block px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-semibold rounded-lg transition shadow-sm">
                                {{ $section->button_text }} →
                            </a>
                        </div>
                    @endif
                </div>

            {{-- -----------------------------------------------
                 CUSTOM: TANYA JAWAB / FAQ
            ----------------------------------------------- --}}
            @elseif($section->type == 'faq')
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 sm:p-8 max-w-4xl mx-auto">
                    @if($section->title)
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                            <span>❓</span> {{ $section->title }}
                        </h2>
                    @endif
                    <div class="prose prose-sm sm:prose-base max-w-none text-slate-700 leading-relaxed">
                        {!! $section->content !!}
                    </div>
                </div>
            @endif

        @endforeach
    @endif

</div>

@endsection
