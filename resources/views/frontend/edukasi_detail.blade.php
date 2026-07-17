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
    /* Sama persis dengan .program-cover-box di halaman detail program kerja */
    .edu-detail-img-box {
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
    .edu-detail-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
@endpush

@section('content')

{{-- Header: judul & meta (dalam max-w-4xl) --}}
<div class="max-w-4xl mx-auto mb-6 md:mb-8">
    <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Materi Edukasi</span>
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mt-4 mb-2 leading-tight">{{ $education->title }}</h1>
    <p class="text-gray-400 text-sm">Dipublikasikan pada {{ $education->created_at->format('d M Y') }}</p>
</div>

{{-- Gambar cover — LEBAR PENUH (di luar max-w-4xl), sama seperti program kerja --}}
@if($education->thumbnail)
<div class="edu-detail-img-box mb-6 md:mb-8 shadow-md">
    @if($education->video_url)
        <a href="{{ $education->video_url }}" target="_blank" style="display:block;width:100%;height:100%;" title="Klik untuk menonton video">
            <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}">
        </a>
    @else
        <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}">
    @endif
</div>
@endif

{{-- Konten artikel (dalam max-w-4xl) --}}
<div class="max-w-4xl mx-auto">
    <div class="prose max-w-none prose-red bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
        {!! $education->content !!}
    </div>

    <div class="mt-12 pt-8 border-t border-gray-200">
        <a href="{{ route('educations') }}" class="text-red-600 hover:text-red-800 font-semibold flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Pusat Edukasi
        </a>
    </div>
</div>

@endsection
