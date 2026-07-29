@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    * { box-sizing: border-box; }

    /* =============================================
       LAYOUT DUA KOLOM
    ============================================= */
    .product-layout {
        display: flex;
        gap: 3rem;
        align-items: flex-start;
    }

    /* Kolom kiri — gambar sticky */
    .product-col-image {
        flex: 0 0 48%;
        max-width: 48%;
        position: sticky;
        top: 80px; /* sesuaikan dengan tinggi navbar */
        align-self: flex-start;
    }

    /* Kolom kanan — konten scroll */
    .product-col-info {
        flex: 1;
        min-width: 0;
    }

    @media (max-width: 768px) {
        .product-layout {
            flex-direction: column;
            gap: 1.5rem;
        }
        .product-col-image {
            flex: none;
            max-width: 100%;
            position: static;
        }
    }

    /* =============================================
       GAMBAR UTAMA
    ============================================= */
    .gallery-main-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f5f5f5;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 0.5rem;
    }
    .gallery-main-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Thumbnail strip */
    .gallery-thumbs {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.75rem;
        flex-wrap: wrap;
    }
    .gallery-thumb {
        width: 68px;
        height: 68px;
        border-radius: 0.25rem;
        overflow: hidden;
        border: 1.5px solid #e5e7eb;
        cursor: pointer;
        background: #f5f5f5;
        flex-shrink: 0;
    }
    .gallery-thumb img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .gallery-thumb:hover,
    .gallery-thumb.active {
        border-color: #111827;
    }

    /* =============================================
       INFO PRODUK
    ============================================= */
    .product-name {
        font-size: 2rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.2;
        margin-bottom: 0.75rem;
    }
    @media (max-width: 768px) {
        .product-name { font-size: 1.5rem; }
    }

    /* Kotak harga + marketplace */
    .price-box {
        background: #f5f0e8;
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
        margin: 1.25rem 0;
    }
    .price-box-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.75rem;
        margin-bottom: 0;
    }
    .price-label {
        font-size: 0.7rem;
        color: #6b7280;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .price-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: #111827;
    }
    .market-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .market-label {
        font-size: 0.7rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .market-icons {
        display: flex;
        gap: 0.6rem;
        justify-content: center;
        align-items: center;
    }
    .market-icon-shopee,
    .market-icon-tokopedia,
    .market-icon-wa {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 56px;
        height: 56px;
        text-decoration: none;
        flex-shrink: 0;
        background: transparent;
        border: none;
        box-shadow: none;
        transition: transform 0.2s ease;
    }
    .market-icon-shopee:hover,
    .market-icon-tokopedia:hover,
    .market-icon-wa:hover {
        transform: scale(1.08);
    }
    .market-icon-shopee img,
    .market-icon-tokopedia img,
    .market-icon-wa img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        background: transparent;
        border: none;
        box-shadow: none;
    }


    /* Deskripsi */
    .product-description {
        font-size: 0.9rem;
        color: #4b5563;
        line-height: 1.75;
    }
    .product-description.clamped {
        display: -webkit-box;
        -webkit-line-clamp: 5;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .read-more-btn {
        display: inline-block;
        margin-top: 0.5rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #2563eb;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* =============================================
       VIDEO EMBED
    ============================================= */
    .video-wrapper {
        position: relative;
        padding-top: 56.25%;
        overflow: hidden;
        border-radius: 0.5rem;
        background: #1e293b;
    }
    .video-wrapper iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* =============================================
       SARAN PRODUK (KAMU MUNGKIN SUKA)
    ============================================= */
    .suggestion-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }
    @media (min-width: 1024px) {
        .suggestion-grid { grid-template-columns: repeat(4, 1fr); }
    }
    .suggestion-card {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .suggestion-img-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f5f5f5;
        overflow: hidden;
        border-radius: 0.375rem;
        margin-bottom: 0.6rem;
    }
    .suggestion-img-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        transition: transform .25s;
    }
    .suggestion-card:hover .suggestion-img-box img {
        transform: scale(1.04);
    }
    .suggestion-name {
        font-size: 0.82rem;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.35;
        margin-bottom: 0.2rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .suggestion-price {
        font-size: 0.8rem;
        font-weight: 700;
        color: #374151;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<nav class="mb-6 text-sm text-gray-500 flex items-center gap-1.5 flex-wrap">
    <a href="{{ route('home') }}" class="hover:text-red-600 transition">Beranda</a>
    <span>/</span>
    <a href="{{ route('products') }}" class="hover:text-red-600 transition">Produk Kami</a>
    <span>/</span>
    <span class="text-gray-700 font-medium truncate max-w-xs">{{ $product->name }}</span>
</nav>

{{-- ===== Layout Utama ===== --}}
<div class="product-layout mb-16">

    {{-- ---- Kolom Kiri: Gambar (Sticky) ---- --}}
    <div class="product-col-image">
        @if($product->images->count() > 0)
            <div class="gallery-main-box">
                <img id="main-image"
                     src="{{ asset($product->images->first()->image) }}"
                     alt="{{ $product->name }}">
            </div>

            @if($product->images->count() > 1)
            <div class="gallery-thumbs">
                @foreach($product->images as $i => $img)
                <div class="gallery-thumb {{ $i === 0 ? 'active' : '' }}"
                     onclick="setMainImage(this, '{{ asset($img->image) }}')">
                    <img src="{{ asset($img->image) }}" alt="Gambar {{ $i + 1 }}">
                </div>
                @endforeach
            </div>
            @endif
        @else
            <div class="gallery-main-box">
                <span style="color: #d1d5db; font-size: 1rem;">Tidak ada gambar</span>
            </div>
        @endif
    </div>

    {{-- ---- Kolom Kanan: Info Produk ---- --}}
    <div class="product-col-info">

        {{-- Kategori --}}
        @if($product->category)
            <p style="font-size: 0.75rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 0.4rem;">
                {{ $product->category }}
            </p>
        @endif

        {{-- Nama --}}
        <h1 class="product-name">{{ $product->name }}</h1>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin-bottom: 0;">

        {{-- Kotak Harga + Marketplace & WhatsApp --}}
        @if($product->price || $product->shopee_url || $product->tokopedia_url || $product->whatsapp_url)
        <div class="price-box">
            <div class="price-box-inner">
                {{-- Harga --}}
                @if($product->price)
                <div>
                    <p class="price-label">Harga</p>
                    <p class="price-value">{{ $product->price }}</p>
                </div>
                @endif

                {{-- Ikon marketplace & WhatsApp --}}
                @if($product->shopee_url || $product->tokopedia_url || $product->whatsapp_url)
                <div class="market-section">
                    <p class="market-label">Tersedia di</p>
                    <div class="market-icons">
                        @if($product->shopee_url)
                            <a href="{{ $product->shopee_url }}" target="_blank" rel="noopener noreferrer"
                               class="market-icon-shopee" title="Shopee">
                                <img src="{{ asset('images/shope.png') }}" alt="Shopee">
                            </a>
                        @endif
                        @if($product->tokopedia_url)
                            <a href="{{ $product->tokopedia_url }}" target="_blank" rel="noopener noreferrer"
                               class="market-icon-tokopedia" title="Tokopedia">
                                <img src="{{ asset('images/tokopedia.png') }}" alt="Tokopedia">
                            </a>
                        @endif
                        @if($product->whatsapp_url)
                            <a href="{{ $product->formatted_whatsapp_url }}" target="_blank" rel="noopener noreferrer"
                               class="market-icon-wa" title="WhatsApp">
                                <img src="{{ asset('images/wa.png') }}" alt="WhatsApp">
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 1.25rem 0;">
        @endif

        {{-- Nama lengkap / subtitle --}}
        @if($product->description)
            <div>
                <p style="font-weight: 700; font-size: 0.9rem; color: #111827; margin-bottom: 0.6rem;">
                    {{ $product->name }}{{ $product->category ? ' — ' . $product->category : '' }}
                </p>
                <div class="product-description clamped" id="desc-text">
                    {!! $product->description !!}
                </div>
                <button class="read-more-btn" id="read-more-btn" onclick="toggleDesc()">READ MORE</button>
            </div>
        @endif

        {{-- Video --}}
        @if($product->video_url)
        @php
            $videoUrl = $product->video_url;
            if (preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $videoUrl, $m)) {
                $videoUrl = 'https://www.youtube.com/embed/' . $m[1];
            } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m)) {
                $videoUrl = 'https://player.vimeo.com/video/' . $m[1];
            }
        @endphp
        <div style="margin-top: 1.5rem;">
            <p style="font-size: 0.78rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">Video Produk</p>
            <div class="video-wrapper">
                <iframe src="{{ $videoUrl }}"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        loading="lazy"
                        title="Video {{ $product->name }}"></iframe>
            </div>
        </div>
        @endif

    </div>
</div>

{{-- ===== Kamu Mungkin Suka ===== --}}
@if($suggestions->count() > 0)
<div class="border-t border-gray-100 pt-10 mb-12">
    <h2 style="font-size: 1.35rem; font-weight: 700; color: #2563eb; margin-bottom: 1.25rem;">
        Kamu Mungkin Suka
    </h2>

    <div class="suggestion-grid">
        @foreach($suggestions as $sug)
        <a href="{{ route('products.detail', $sug->slug) }}" class="suggestion-card">
            @if($sug->images->count() > 0)
                <div class="suggestion-img-box">
                    <img src="{{ asset($sug->images->first()->image) }}" alt="{{ $sug->name }}">
                </div>
            @else
                <div class="suggestion-img-box" style="display: flex; align-items: center; justify-content: center;">
                    <span style="color: #d1d5db; font-size: 0.75rem;">No image</span>
                </div>
            @endif
            <p class="suggestion-name">{{ $sug->name }}</p>
            @if($sug->price)
                <p class="suggestion-price">{{ $sug->price }}</p>
            @endif
        </a>
        @endforeach
    </div>
</div>
@endif

{{-- Kembali --}}
<div class="border-t border-gray-100 pt-6 mb-8">
    <a href="{{ route('products') }}" class="text-red-600 hover:text-red-800 text-sm font-semibold transition">
        &larr; Kembali ke Produk Kami
    </a>
</div>

@endsection

@push('scripts')
<script>
    function setMainImage(thumb, src) {
        document.getElementById('main-image').src = src;
        document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    function toggleDesc() {
        const desc = document.getElementById('desc-text');
        const btn  = document.getElementById('read-more-btn');
        if (desc.classList.contains('clamped')) {
            desc.classList.remove('clamped');
            btn.textContent = 'SHOW LESS';
        } else {
            desc.classList.add('clamped');
            btn.textContent = 'READ MORE';
        }
    }
</script>
@endpush
