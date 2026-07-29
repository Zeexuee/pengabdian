@extends('layouts.app')

@section('title', $education->title)

@section('meta_tags')
    <meta name="title" content="{{ $education->title }}">
    <meta name="description" content="{{ Str::limit(strip_tags($education->content), 150) }}">
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $education->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($education->content), 150) }}">
    @if($education->thumbnail)
    <meta property="og:image" content="{{ asset('storage/' . $education->thumbnail) }}">
    @endif
@endsection

@push('styles')
<style>
    * { box-sizing: border-box; }
    body { overflow-x: hidden; }

    /* Custom scrollbar */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Block Card container */
    .block-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        overflow: hidden;
    }

    /* Image Block — 100% uncropped */
    .block-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 560px;
        overflow: hidden;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .block-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Video Block */
    .block-video-wrapper {
        position: relative;
        padding-top: 56.25%;
        overflow: hidden;
        border-radius: .75rem;
        background: #1e293b;
        box-shadow: 0 4px 20px rgba(0,0,0,.15);
    }
    .block-video-wrapper iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    /* Text Block Styling */
    .block-text-content {
        width: 100%;
        line-height: 1.8;
        font-size: 1.05rem;
        color: #334155;
    }
    .block-text-content p {
        margin-bottom: 1.25rem;
    }
    .block-text-content h1, 
    .block-text-content h2, 
    .block-text-content h3, 
    .block-text-content h4 {
        color: #0f172a;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    .block-text-content h1 { font-size: 1.85rem; }
    .block-text-content h2 { font-size: 1.5rem; }
    .block-text-content h3 { font-size: 1.25rem; }
    .block-text-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .block-text-content ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1.25rem;
    }
    .block-text-content li {
        margin-bottom: 0.4rem;
    }
    .block-text-content blockquote {
        border-left: 4px solid #dc2626;
        padding-left: 1rem;
        font-style: italic;
        color: #475569;
        margin: 1.25rem 0;
        background: #f8fafc;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }

    /* Cover Thumbnail Box */
    .edu-detail-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 520px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0,0,0,.12);
    }
    .edu-detail-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto py-4 md:py-8">

    {{-- Breadcrumb --}}
    <nav class="mb-6 text-sm text-gray-500 flex items-center gap-1.5 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-red-600 transition">Beranda</a>
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('educations') }}" class="hover:text-red-600 transition">Edukasi</a>
        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-gray-700 font-medium truncate max-w-xs">{{ $education->title }}</span>
    </nav>

    {{-- Header Edukasi --}}
    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Materi Edukasi</span>
    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mt-3 mb-3">{{ $education->title }}</h1>
    <p class="text-gray-400 text-sm mb-6">Dipublikasikan pada {{ $education->created_at->format('d M Y') }}</p>

    {{-- Gambar cover utama --}}
    @if($education->thumbnail)
        <div class="edu-detail-img-box mb-8 shadow-md">
            @if($education->video_url)
                <a href="{{ $education->video_url }}" target="_blank" style="display:block;width:100%;height:100%;" title="Klik untuk menonton video">
                    <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}">
                </a>
            @else
                <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}">
            @endif
        </div>
    @endif

    {{-- Konten Utama --}}
    @if($education->content)
        <div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm mb-8">
            <div class="block-text-content">
                @if(Str::startsWith(trim($education->content), '<'))
                    {!! $education->content !!}
                @else
                    {!! nl2br(e($education->content)) !!}
                @endif
            </div>
        </div>
    @endif

    {{-- ── Dynamic Content Blocks (Sama seperti Program Kerja & Berita) ── --}}
    @if(isset($blocks) && $blocks->count() > 0)
        <div class="space-y-8 mb-12">
            @foreach($blocks as $block)

                {{-- Gambar --}}
                @if($block->type === 'image')
                    <div class="block-card">
                        @if($block->title)
                            <div class="px-5 pt-5 pb-3 md:px-7 md:pt-6">
                                <h2 class="text-lg md:text-xl font-bold text-gray-800">{{ $block->title }}</h2>
                            </div>
                        @endif
                        <div class="block-img-box">
                            <img src="{{ asset('storage/' . $block->image) }}"
                                 alt="{{ $block->title ?? 'Gambar Edukasi' }}">
                        </div>
                    </div>

                {{-- Video --}}
                @elseif($block->type === 'video')
                    <div class="block-card p-4 md:p-6 max-w-4xl mx-auto">
                        @if($block->title)
                            <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 text-center">{{ $block->title }}</h2>
                        @endif

                        @if($block->video_file)
                            <div class="rounded-xl overflow-hidden bg-black shadow-md flex items-center justify-center">
                                <video controls class="w-full max-h-[500px] rounded-xl">
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
                                <div class="block-video-wrapper">
                                    <iframe src="https://www.youtube.com/embed/{{ $vid }}"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
                            @else
                                <a href="{{ $block->video_url }}" target="_blank"
                                   class="inline-flex items-center gap-2 px-5 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                                    Buka Video
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            @endif
                        @endif
                    </div>

                {{-- Teks --}}
                @elseif($block->type === 'text')
                    <div class="block-card p-6 md:p-10 w-full">
                        @if($block->title)
                            <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4 pb-3 border-b border-gray-100">{{ $block->title }}</h2>
                        @endif
                        <div class="block-text-content">
                            @if(Str::startsWith(trim($block->content), '<'))
                                {!! $block->content !!}
                            @else
                                {!! nl2br(e($block->content)) !!}
                            @endif
                        </div>
                    </div>
                @endif

            @endforeach
        </div>
    @endif

    {{-- Kembali --}}
    <div class="mt-12 pt-8 border-t border-gray-200">
        <a href="{{ route('educations') }}" class="text-red-600 hover:text-red-800 font-semibold inline-flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Pusat Edukasi
        </a>
    </div>
</div>
@endsection
