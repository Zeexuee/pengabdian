@extends('layouts.app')

@section('title', 'Berita')

@section('content')
    <h1>Berita Terbaru</h1>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
        @forelse($news as $item)
            <article style="border: 1px solid #ccc; padding: 1rem; border-radius: 8px;">
                <h2 style="margin-top: 0;">{{ $item->title }}</h2>
                <p>
                    <small style="color: #666;">
                        Ditulis oleh: {{ $item->author->name ?? 'Anonim' }} | 
                        Di-publish: {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                    </small>
                </p>
                
                @if($item->thumbnail)
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" style="width: 100%; height: auto; margin-bottom: 1rem;">
                @endif
                
                {{-- Menampilkan 150 karakter pertama dari konten --}}
                <p>{{ Str::limit($item->content, 150) }}</p>
                
                <a href="#" style="color: blue;">Baca Selengkapnya &rarr;</a>
            </article>
        @empty
            <p>Belum ada berita yang dipublikasikan saat ini.</p>
        @endforelse
    </div>

    {{-- Paginasi bawaan Laravel --}}
    <div style="margin-top: 2rem;">
        {{ $news->links() }}
    </div>
@endsection
