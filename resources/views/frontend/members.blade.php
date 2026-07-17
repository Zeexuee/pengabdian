@extends('layouts.app')

@section('title', 'Struktur Anggota')

@push('styles')
<style>
    /* Fixed-height member card for consistent layout */
    .member-card {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Fixed avatar size — does not stretch */
    .member-avatar {
        width: 80px;
        height: 80px;
        min-width: 80px;
        min-height: 80px;
        flex-shrink: 0;
    }
    @media (min-width: 640px) {
        .member-avatar {
            width: 96px;
            height: 96px;
            min-width: 96px;
            min-height: 96px;
        }
    }

    /* Info block: fixed height so all cards align at the bottom */
    .member-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        width: 100%;
        text-align: center;
    }

    /* Clamp name to 2 lines max */
    .member-name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.5rem; /* fixed space for 2 lines */
    }

    /* Clamp position to 1 line */
    .member-position {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 1.25rem; /* fixed space for 1 line */
    }

    /* Bio with custom scrollbar */
    .member-bio {
        display: block; /* Visible on mobile and desktop */
        height: 4rem; /* fixed space */
        overflow-y: auto;
        padding-right: 2px;
    }
    
    /* Styling for custom scrollbar in member-bio */
    .member-bio::-webkit-scrollbar { width: 4px; }
    .member-bio::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .member-bio::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .member-bio::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* ======================================================
       FOTO KEGIATAN (atas & bawah) — gambar penuh tanpa crop
    ====================================================== */
    .activity-photo-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        max-height: 560px;
        overflow: hidden;
        border-radius: 1rem;
        background: #1e293b;        /* letterbox area */
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 24px rgba(0,0,0,.10);
    }
    .activity-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    @media (max-width: 639px) {
        .activity-photo-box { aspect-ratio: 4 / 3; }
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="mb-8 md:mb-12">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-2 md:mb-3">Struktur Pengurus &amp; Anggota</h1>
    <p class="text-gray-500 text-sm md:text-base max-w-2xl pl-5">Mengenal lebih dekat para penggerak komunitas yang berdedikasi.</p>
</div>

{{-- ─── Gambar Di Atas Daftar Anggota ────────────────────────────── --}}
@php
    $sectionsAbove = $sections->where('position', 'above');
    $sectionsBelow = $sections->where('position', 'below');
@endphp

@if($sectionsAbove->count() > 0)
    <div class="space-y-4 md:space-y-8 mb-8 md:mb-12">
        @foreach($sectionsAbove as $sec)
            <div class="activity-photo-box">
                <img src="{{ asset('storage/' . $sec->image) }}"
                     alt="Foto Kegiatan">
            </div>
        @endforeach
    </div>
@endif

{{-- ─── Daftar Anggota ─────────────────────────────────────────────── --}}
{{-- Mobile: 2 kolom | Tablet: 3 kolom | Desktop: 4 kolom             --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6 mb-12 md:mb-16">
    @forelse($members as $member)
        <div class="member-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-4 md:p-6 hover:shadow-md transition-shadow duration-200">

            {{-- Avatar — fixed size, never stretches --}}
            <div class="member-avatar rounded-full bg-gray-100 mx-auto mb-3 overflow-hidden border-4 border-white shadow-sm ring-2 ring-gray-100">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}"
                         alt="{{ $member->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-blue-50">
                        <svg class="w-10 h-10 text-blue-200" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Info block — fixed-height clamped text --}}
            <div class="member-info">
                <h3 class="member-name text-sm md:text-base font-bold text-gray-900 leading-tight">{{ $member->name }}</h3>
                <p class="member-position text-blue-600 text-xs md:text-sm font-semibold mt-1">{{ $member->position }}</p>
                {{-- Bio: only visible sm+ and always reserves 3 lines of space --}}
                <p class="member-bio text-gray-400 text-xs mt-2">{{ $member->bio ?? '' }}</p>
            </div>

        </div>
    @empty
        <div class="col-span-2 sm:col-span-3 lg:col-span-4 py-12 md:py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <p class="text-gray-500 font-medium text-sm md:text-base">Data struktur anggota belum ditambahkan.</p>
        </div>
    @endforelse
</div>

{{-- ─── Gambar Di Bawah Daftar Anggota ───────────────────────────── --}}
@if($sectionsBelow->count() > 0)
    <div class="space-y-4 md:space-y-8 mb-8">
        @foreach($sectionsBelow as $sec)
            <div class="activity-photo-box">
                <img src="{{ asset('storage/' . $sec->image) }}"
                     alt="Foto Kegiatan">
            </div>
        @endforeach
    </div>
@endif

@endsection
