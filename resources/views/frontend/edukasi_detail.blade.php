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

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="mb-8">
        <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Materi Edukasi</span>
        <h1 class="text-4xl font-bold text-gray-900 mt-4 mb-4">{{ $education->title }}</h1>
        <p class="text-gray-500 text-sm">Dipublikasikan pada {{ $education->created_at->format('d M Y') }}</p>
    </div>
    
    @if($education->video_url)
    <div class="mb-10 rounded-2xl overflow-hidden shadow-lg bg-gray-900 flex justify-center items-center relative aspect-video">
        <a href="{{ $education->video_url }}" target="_blank" class="absolute inset-0 flex flex-col justify-center items-center text-white hover:bg-black/30 transition duration-300">
            <svg class="w-16 h-16 text-red-600 mb-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" /></svg>
            <span class="font-bold text-lg">Tonton Video Materi</span>
        </a>
        @if($education->thumbnail)
            <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}" class="w-full h-full object-cover opacity-60">
        @endif
    </div>
    @elseif($education->thumbnail)
    <div class="mb-10 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
        <img src="{{ asset('storage/' . $education->thumbnail) }}" alt="{{ $education->title }}" class="w-full h-auto object-cover">
    </div>
    @endif
    
    <!-- Render konten CKEditor -->
    <div class="prose max-w-none prose-blue bg-white p-8 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
        {!! $education->content !!}
    </div>
    
    <div class="mt-12 pt-8 border-t border-gray-200">
        <a href="{{ route('educations') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Pusat Edukasi
        </a>
    </div>
</div>
@endsection
