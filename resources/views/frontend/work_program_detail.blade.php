@extends('layouts.app')

@section('title', $work_program->title)

@push('styles')
<style>
    * { box-sizing: border-box; }
    body { overflow-x: hidden; }

    /* =============================================
       SCROLLBAR CUSTOM
    ============================================= */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* =============================================
       BLOCK CARD — container konsisten
    ============================================= */
    .block-card {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        overflow: hidden;
    }

    /* =============================================
       GAMBAR BLOCK — contain, letterbox gelap
    ============================================= */
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

    /* =============================================
       VIDEO BLOCK — 16:9 responsif
    ============================================= */
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

    /* =============================================
       TEXT BLOCK
    ============================================= */
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
    .block-text-content table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.25rem;
    }
    .block-text-content table th,
    .block-text-content table td {
        border: 1px solid #cbd5e1;
        padding: 0.75rem 1rem;
    }
    .block-text-content table th {
        background-color: #f1f5f9;
        font-weight: 600;
        color: #1e293b;
    }

    /* =============================================
       COVER GAMBAR PROGRAM — contain
    ============================================= */
    .program-cover-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 480px;
        background: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1rem;
        overflow: hidden;
    }
    .program-cover-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Badge */
    .badge-completed { background: #dcfce7; color: #166534; }
    .badge-ongoing   { background: #dbeafe; color: #1e40af; }
    .badge-planned   { background: #f3f4f6; color: #374151; }
</style>
@endpush

@section('content')

{{-- ── Breadcrumb ── --}}
<nav class="mb-6 text-sm text-gray-500 flex items-center gap-1.5 flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-red-600 transition">Beranda</a>
    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('work_programs') }}" class="hover:text-red-600 transition">Program Kerja</a>
    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-gray-700 font-medium truncate max-w-xs">{{ $work_program->title }}</span>
</nav>

{{-- ── Header Program ── --}}
<div class="mb-8 md:mb-12">

    {{-- Cover gambar utama (jika ada) --}}
    @if($work_program->image)
        <div class="program-cover-box mb-6 md:mb-8 shadow-md">
            <img src="{{ asset('storage/' . $work_program->image) }}"
                 alt="{{ $work_program->title }}">
        </div>
    @endif

    {{-- Judul + badge + meta --}}
    <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight max-w-3xl">
            {{ $work_program->title }}
        </h1>
        <span class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-semibold
            {{ $work_program->status === 'completed' ? 'badge-completed' :
               ($work_program->status === 'ongoing'   ? 'badge-ongoing'   : 'badge-planned') }}">
            @php
                $labels = ['completed' => 'Selesai', 'ongoing' => 'Berlangsung', 'planned' => 'Direncanakan'];
                echo $labels[$work_program->status] ?? ucfirst($work_program->status);
            @endphp
        </span>
    </div>

    {{-- Tanggal --}}
    <p class="text-sm text-gray-400 flex items-center gap-1.5 mb-5">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        {{ $work_program->start_date ? $work_program->start_date->format('d M Y') : 'TBA' }}
        &nbsp;—&nbsp;
        {{ $work_program->end_date ? $work_program->end_date->format('d M Y') : 'TBA' }}
    </p>

    {{-- Deskripsi singkat --}}
    @if($work_program->description)
        <div class="bg-white border border-gray-100 rounded-2xl p-6 md:p-8 shadow-sm">
            <div class="block-text-content">
                @if(Str::startsWith(trim($work_program->description), '<'))
                    {!! $work_program->description !!}
                @else
                    {!! nl2br(e($work_program->description)) !!}
                @endif
            </div>
        </div>
    @endif
</div>

{{-- ── Content Blocks ── --}}
@if($blocks->count() > 0)
    <div class="space-y-8 mb-16">
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
                             alt="{{ $block->title ?? 'Gambar' }}">
                    </div>
                </div>

            {{-- Video --}}
            @elseif($block->type === 'video')
                <div class="block-card px-5 py-6 md:px-7 md:py-7 max-w-4xl mx-auto">
                    @if($block->title)
                        <h2 class="text-lg md:text-xl font-bold text-gray-800 mb-4 text-center">{{ $block->title }}</h2>
                    @endif
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

{{-- ── Kembali ── --}}
<div class="border-t border-gray-100 pt-8 mt-4 mb-12">
    <a href="{{ route('work_programs') }}"
       class="inline-flex items-center gap-2 text-red-600 hover:text-red-800 font-semibold transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Program Kerja
    </a>
</div>

@endsection
