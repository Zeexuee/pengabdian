@extends('layouts.app')

@section('title', 'Berita Terkini')

@push('styles')
<style>
    /* Grid: 2 kolom mobile, 4 kolom desktop */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    @media (min-width: 1024px) {
        .news-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
    }

    /* Card */
    .news-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .news-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.10);
        transform: translateY(-2px);
    }

    /* Frame gambar gelap (object-contain) */
    .news-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        position: relative;
        overflow: hidden;
        background: #1e293b;
        flex-shrink: 0;
    }
    .news-img-box img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        object-position: center;
    }

    /* Placeholder tanpa gambar */
    .news-placeholder {
        width: 100%;
        aspect-ratio: 16 / 9;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Konten card */
    .news-card-body {
        padding: 0.875rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .news-card-date {
        font-size: 0.7rem;
        font-weight: 700;
        color: #2563eb;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .news-card-title {
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
    .news-card-desc {
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
        .news-card-desc { display: none; }
    }
    .news-card-btn {
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
    .news-card-btn:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-red-600 pl-4 mb-6">Berita Terkini</h1>
    <p class="text-gray-600 max-w-2xl">Dapatkan informasi, pengumuman, dan artikel terbaru dari aktivitas komunitas kami.</p>
</div>

<div class="news-grid">
    @forelse($news as $item)
        <div class="news-card">
            @if($item->thumbnail)
                <div class="news-img-box">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}">
                </div>
            @else
                <div class="news-placeholder">
                    <svg width="40" height="40" fill="none" stroke="#7dd3fc" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif

            <div class="news-card-body">
                <p class="news-card-date">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $item->published_at ? $item->published_at->format('d M Y') : 'Baru Saja' }}
                </p>
                <h3 class="news-card-title">{{ $item->title }}</h3>
                <div class="news-card-desc">{!! Str::limit(strip_tags($item->content), 100) !!}</div>
                <a href="{{ route('news.detail', $item->slug) }}" class="news-card-btn">Baca Selengkapnya</a>
            </div>
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: #6b7280; background: #f9fafb; border-radius: 0.75rem; border: 2px dashed #e5e7eb;">
            <svg style="width:3rem;height:3rem;margin:0 auto 1rem;color:#d1d5db" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20"/></svg>
            <p style="font-size:1rem;font-weight:600;">Belum ada berita yang dipublikasikan saat ini.</p>
            <p style="font-size:0.85rem;margin-top:0.5rem;">Coba kembali lagi nanti.</p>
        </div>
    @endforelse
</div>

<!-- Navigasi Halaman (Pagination) -->
@if(isset($news) && $news->hasPages())
    <div class="mt-12 bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
        {{ $news->links() }}
    </div>
@endif
@endsection
