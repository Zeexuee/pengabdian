@extends('layouts.app')

@section('title', 'Edukasi')

@push('styles')
<style>
    /* Grid: 2 kolom mobile, 4 kolom desktop */
    .edu-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    @media (min-width: 1024px) {
        .edu-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
    }

    /* Card */
    .edu-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .edu-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.10);
        transform: translateY(-2px);
    }

    /* Frame gambar gelap (object-contain) */
    .edu-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        position: relative;
        overflow: hidden;
        background: #1e293b;
        flex-shrink: 0;
    }
    .edu-img-box img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        object-position: center;
    }

    /* Placeholder tanpa gambar */
    .edu-placeholder {
        width: 100%;
        aspect-ratio: 16 / 9;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Konten card */
    .edu-card-body {
        padding: 0.875rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .edu-card-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        margin-bottom: 0.4rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .edu-card-desc {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.75rem;
        flex-grow: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 640px) {
        .edu-card-desc { display: none; }
    }
    .edu-card-btn {
        display: block;
        text-align: center;
        padding: 0.35rem 0.75rem;
        background: #2563eb;
        color: #fff;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-decoration: none;
        margin-top: auto;
        transition: background .2s;
    }
    .edu-card-btn:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-red-600 pl-4 mb-6">Pusat Edukasi</h1>
    <p class="text-gray-600 max-w-2xl">Materi pembelajaran, tutorial, dan artikel informatif untuk meningkatkan wawasan.</p>
</div>

<div class="edu-grid">
    @forelse($educations as $edu)
        <div class="edu-card">
            @if($edu->thumbnail)
                <div class="edu-img-box">
                    <img src="{{ asset('storage/' . $edu->thumbnail) }}" alt="{{ $edu->title }}">
                </div>
            @else
                <div class="edu-placeholder">
                    <svg width="40" height="40" fill="none" stroke="#93c5fd" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            @endif
            <div class="edu-card-body">
                <h2 class="edu-card-title">{{ $edu->title }}</h2>
                <div class="edu-card-desc">{!! Str::limit(strip_tags($edu->content), 100) !!}</div>
                <a href="{{ route('educations.detail', $edu->slug) }}" class="edu-card-btn">Mulai Belajar</a>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: #6b7280; background: #f9fafb; border-radius: 0.75rem; border: 2px dashed #e5e7eb;">
            Belum ada materi edukasi yang dipublikasikan.
        </div>
    @endforelse
</div>

@if(isset($educations) && $educations->hasPages())
    <div class="mt-12 bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
        {{ $educations->links() }}
    </div>
@endif
@endsection
