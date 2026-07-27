@extends('layouts.app')

@section('title', 'Program Kerja')

@push('styles')
<style>
    /* =============================================
       GLOBAL
    ============================================= */
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
       PROGRAM CARD — konsisten ukuran antar kartu
    ============================================= */
    .program-card {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 1.25rem;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        overflow: hidden;
        transition: box-shadow .25s ease, transform .2s ease;
    }
    .program-card:hover {
        box-shadow: 0 8px 28px rgba(0,0,0,.10);
        transform: translateY(-2px);
    }

    /* =============================================
       GAMBAR PROGRAM — contain, tampil penuh & simetris
    ============================================= */
    /* Mobile: full-width dengan rasio 16:9 */
    .program-img-box {
        width: 100%;
        aspect-ratio: 16 / 9;
        position: relative;
        overflow: hidden;
        background: #1e293b;
        flex-shrink: 0;
    }
    /* Desktop: lebar tetap, tinggi mengikuti tinggi kartu secara otomatis */
    @media (min-width: 768px) {
        .program-img-box {
            width: 280px;
            aspect-ratio: unset;
            /* align-self: stretch sudah diatur oleh parent flex items-stretch */
            min-height: 200px;
        }
    }
    /* Gambar mengisi kotak sepenuhnya via absolute positioning */
    .program-img-box img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        object-position: center;
    }

    /* =============================================
       JUDUL — max 2 baris
    ============================================= */
    .program-title {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* =============================================
       DESKRIPSI — max 4 baris, scrollable
    ============================================= */
    .program-desc {
        max-height: 6rem;      /* ~4 baris teks */
        overflow-y: auto;
        padding-right: 4px;
        font-size: .9rem;
        color: #4b5563;
        line-height: 1.6;
    }

    /* =============================================
       BADGE STATUS
    ============================================= */
    .badge-completed { background: #dcfce7; color: #166534; }
    .badge-ongoing   { background: #dbeafe; color: #1e40af; }
    .badge-planned   { background: #f3f4f6; color: #374151; }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="mb-8 md:mb-12">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 border-l-4 border-red-600 pl-4 mb-2 md:mb-3">
        Program Kerja Komunitas
    </h1>
    <p class="text-gray-500 text-sm md:text-base max-w-2xl pl-5">
        Daftar kegiatan dan inisiatif yang kami rencanakan dan sedang jalankan.
    </p>
</div>

{{-- Daftar Program --}}
<div class="space-y-6 mb-16">
    @forelse($workPrograms as $program)

        <a href="{{ route('work_programs.detail', $program->slug ?: $program->id) }}"
           class="block program-card group">
            <div class="flex flex-col {{ $program->image ? 'md:flex-row' : '' }}" style="align-items: stretch;">

                {{-- Gambar — contain, tampil penuh --}}
                @if($program->image)
                    <div class="program-img-box">
                        <img src="{{ asset('storage/' . $program->image) }}"
                             alt="{{ $program->title }}">
                    </div>
                @endif

                {{-- Konten --}}
                <div class="flex flex-col justify-center gap-3 p-5 md:p-7 flex-grow min-w-0">

                    {{-- Baris judul + badge --}}
                    <div class="flex items-start justify-between gap-3">
                        <h2 class="program-title flex-1 min-w-0">{{ $program->title }}</h2>
                        <span class="flex-shrink-0 px-3 py-1 text-xs font-semibold rounded-full
                            {{ $program->status === 'completed' ? 'badge-completed' :
                               ($program->status === 'ongoing'   ? 'badge-ongoing'   : 'badge-planned') }}">
                            @php
                                $labels = ['completed' => 'Selesai', 'ongoing' => 'Berlangsung', 'planned' => 'Direncanakan'];
                                echo $labels[$program->status] ?? ucfirst($program->status);
                            @endphp
                        </span>
                    </div>

                    {{-- Jadwal --}}
                    <p class="text-xs text-gray-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $program->start_date ? $program->start_date->format('d M Y') : 'TBA' }}
                        &nbsp;—&nbsp;
                        {{ $program->end_date ? $program->end_date->format('d M Y') : 'TBA' }}
                    </p>

                    {{-- Deskripsi — max 4 baris, scrollable jika panjang --}}
                    <div class="program-desc custom-scrollbar">
                        {{ $program->description }}
                    </div>

                    {{-- Indikator klik --}}
                    <div class="mt-2 flex items-center gap-1 text-red-600 text-sm font-semibold group-hover:gap-2 transition-all">
                        Lihat Detail
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </div>

                </div>
            </div>
        </a>

    @empty
        <div class="py-16 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-gray-400 font-medium">Belum ada data program kerja.</p>
        </div>
    @endforelse
</div>

@endsection
