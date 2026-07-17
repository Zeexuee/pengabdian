@extends('layouts.app')

@section('title', 'Produk Kami')

@push('styles')
<style>
    /* Grid: 2 kolom mobile, 4 kolom desktop */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
    @media (min-width: 1024px) {
        .product-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
    }

    /* Card */
    .product-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        display: flex;
        flex-direction: column;
        transition: box-shadow .2s ease, transform .2s ease;
        text-decoration: none;
        color: inherit;
    }
    .product-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,.10);
        transform: translateY(-2px);
    }

    /* Kotak gambar — rasio 1:1 */
    .product-img-box {
        width: 100%;
        aspect-ratio: 1 / 1;
        position: relative;
        overflow: hidden;
        background: #1e293b;
        flex-shrink: 0;
    }
    .product-img-box img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    /* Placeholder */
    .product-placeholder {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 2rem;
    }

    /* Body card */
    .product-card-body {
        padding: 0.875rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }
    .product-card-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        margin-bottom: 0.25rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-card-category {
        font-size: 0.7rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    .product-card-price {
        font-size: 0.8rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 0.75rem;
    }
    .product-card-btn {
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
    .product-card-btn:hover { background: #1d4ed8; }
</style>
@endpush

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-2">Produk Kami</h1>
    <p class="text-gray-500 max-w-2xl pl-5">Produk daur ulang hasil pengolahan sampah dari Bank Sampah Sejahtera Gemilang RW. 06.</p>
</div>

<div class="product-grid">
    @forelse($products as $product)
        <a href="{{ route('products.detail', $product->slug) }}" class="product-card">

            @if($product->images->count() > 0)
                <div class="product-img-box">
                    <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}">
                </div>
            @else
                <div class="product-placeholder">—</div>
            @endif

            <div class="product-card-body">
                @if($product->category)
                    <p class="product-card-category">{{ $product->category }}</p>
                @endif
                <h2 class="product-card-name">{{ $product->name }}</h2>
                @if($product->price)
                    <p class="product-card-price">{{ $product->price }}</p>
                @endif
                <span class="product-card-btn">Lihat Detail</span>
            </div>

        </a>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 1rem; color: #6b7280; background: #f9fafb; border-radius: 0.75rem; border: 2px dashed #e5e7eb;">
            <p style="font-size: 1rem; font-weight: 600;">Belum ada produk yang tersedia saat ini.</p>
            <p style="font-size: 0.85rem; margin-top: 0.5rem;">Segera hadir produk-produk terbaru kami.</p>
        </div>
    @endforelse
</div>

@if(isset($products) && $products->hasPages())
    <div class="mt-10 bg-white px-4 py-3 border-t border-gray-200 sm:px-6 rounded-lg shadow-sm">
        {{ $products->links() }}
    </div>
@endif

@endsection
