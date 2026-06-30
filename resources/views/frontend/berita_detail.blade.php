@extends('layouts.app')

@section('title', $news->title)

@section('meta_tags')
    <meta name="title" content="{{ $news->title }}">
    <meta name="description" content="{{ Str::limit(strip_tags($news->content), 150) }}">
    
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $news->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($news->content), 150) }}">
    @if($news->thumbnail)
    <meta property="og:image" content="{{ asset('storage/' . $news->thumbnail) }}">
    @endif
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $news->title }}</h1>
    
    <div class="flex items-center text-gray-500 text-sm mb-8 space-x-4">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            {{ $news->author->name ?? 'Anonim' }}
        </span>
        <span>&bull;</span>
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            {{ $news->published_at ? $news->published_at->format('d M Y') : 'Draft' }}
        </span>
    </div>
    
    @if($news->thumbnail)
    <div class="mb-10 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="{{ $news->title }}" class="w-full h-auto object-cover">
    </div>
    @endif
    
    <!-- Render konten CKEditor -->
    <div class="prose max-w-none prose-blue prose-img:rounded-xl">
        {!! $news->content !!}
    </div>
    
    <div class="mt-12 pt-8 border-t border-gray-200">
        <a href="{{ route('news') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Berita
        </a>
    </div>
</div>
@endsection
