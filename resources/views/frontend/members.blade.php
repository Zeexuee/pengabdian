@extends('layouts.app')

@section('title', 'Struktur Anggota Organisasi')

@push('styles')
<style>
    /* Fixed-height member card for consistent layout */
    .member-card {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Fixed avatar size — uncropped photo display */
    .member-avatar {
        width: 104px;
        height: 104px;
        min-width: 104px;
        min-height: 104px;
        flex-shrink: 0;
        border-radius: 1rem;
        background: #f8fafc;
        overflow: hidden;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    @media (min-width: 640px) {
        .member-avatar {
            width: 120px;
            height: 120px;
            min-width: 120px;
            min-height: 120px;
        }
    }

    /* Member photo strictly UNCROPPED (object-fit: contain) */
    .member-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 4px;
        display: block;
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
        height: 2.5rem;
    }

    /* Clamp position to 1 line */
    .member-position {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 1.25rem;
    }

    /* Bio with custom scrollbar */
    .member-bio {
        display: block;
        height: 4rem;
        overflow-y: auto;
        padding-right: 2px;
    }
    
    .member-bio::-webkit-scrollbar { width: 4px; }
    .member-bio::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
    .member-bio::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    .member-bio::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    /* Enlarged Division Hero Banner box */
    .division-hero-banner {
        width: 100%;
        min-height: 380px;
        max-height: 560px;
        aspect-ratio: 16 / 7;
        overflow: hidden;
        border-radius: 1.5rem;
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        box-shadow: 0 12px 36px rgba(0,0,0,.18);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Background blur to fill letterbox ambiently */
    .division-hero-bg-blur {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: blur(24px) brightness(0.45);
        transform: scale(1.15);
    }

    /* Main Banner Image strictly UNCROPPED (object-fit: contain) */
    .division-hero-img-full {
        position: relative;
        z-index: 10;
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* Overlay for text readability */
    .division-hero-overlay {
        position: absolute;
        inset: 0;
        z-index: 20;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.35) 50%, rgba(15, 23, 42, 0.1) 100%);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 2rem 2.5rem;
    }

    @media (max-width: 639px) {
        .division-hero-banner {
            min-height: 300px;
            aspect-ratio: 16 / 9;
        }
        .division-hero-overlay {
            padding: 1.25rem 1.5rem;
        }
    }

    /* Filter tab styling */
    .division-tab-btn {
        transition: all 0.2s ease-in-out;
    }
    .division-tab-btn.active {
        background-color: #dc2626;
        color: #ffffff;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.35);
    }
    .division-tab-btn:not(.active) {
        background-color: #ffffff;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }
    .division-tab-btn:not(.active):hover {
        background-color: #f9fafb;
        color: #111827;
        border-color: #d1d5db;
    }
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="mb-6 md:mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 border-l-4 border-red-600 pl-4 mb-2 md:mb-3">Struktur Organisasi RW 006</h1>
    <p class="text-gray-500 text-sm md:text-base max-w-2xl pl-5">Struktur organisasi RW 006 Pakulonan Barat.</p>
</div>

{{-- ─── Tab Navigation Per-Divisi (Tanpa Opsi 'Semua Divisi') ────────── --}}
@if($divisions->count() > 0)
    <div class="mb-8 overflow-x-auto pb-2 no-scrollbar">
        <div class="flex flex-nowrap md:flex-wrap items-center gap-2 md:gap-3" id="division-tabs">
            @foreach($divisions as $div)
                <button type="button" 
                        onclick="showDivisionTab({{ $div->id }}, this)"
                        class="division-tab-btn {{ $loop->first ? 'active' : '' }} px-5 py-2.5 rounded-full text-xs md:text-sm font-semibold tracking-wide cursor-pointer whitespace-nowrap focus:outline-none shadow-sm">
                    {{ $div->name }}
                    <span class="ml-1.5 opacity-80 text-[11px]">({{ $div->members->count() }})</span>
                </button>
            @endforeach
        </div>
    </div>

    {{-- ─── Konten Divisi (Hero Banner Besar & Utuh + Members) ───────── --}}
    <div id="division-contents-wrapper" class="mb-12 md:mb-16">
        @foreach($divisions as $div)
            <div id="division-panel-{{ $div->id }}" 
                 class="division-panel transition-all duration-300 {{ $loop->first ? 'block' : 'hidden' }}">
                
                {{-- Hero Banner Besar & Utuh (Uncropped) --}}
                <div class="division-hero-banner mb-6 md:mb-8">
                    @if($div->banner_image)
                        {{-- Blurred ambient background --}}
                        <img src="{{ asset('storage/' . $div->banner_image) }}" class="division-hero-bg-blur" alt="Background Ambient">
                        {{-- Main full image (100% uncropped) --}}
                        <img src="{{ asset('storage/' . $div->banner_image) }}" class="division-hero-img-full" alt="Hero Banner {{ $div->name }}">
                        
                        {{-- Crisp Overlay Info --}}
                        <div class="division-hero-overlay">
                            <span class="text-red-400 text-xs font-bold uppercase tracking-widest mb-1 drop-shadow-md">Divisi Organisasi</span>
                            <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight drop-shadow-lg">{{ $div->name }}</h2>
                            @if($div->description)
                                <p class="text-gray-200 text-sm md:text-base mt-2 max-w-3xl drop-shadow-md">{{ $div->description }}</p>
                            @endif
                        </div>
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-red-600 via-red-700 to-gray-900 flex flex-col justify-end p-6 md:p-8">
                            <span class="text-red-200 text-xs font-bold uppercase tracking-wider mb-1">Divisi Organisasi</span>
                            <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight">{{ $div->name }}</h2>
                            @if($div->description)
                                <p class="text-red-100 text-sm md:text-base mt-2 max-w-3xl">{{ $div->description }}</p>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Subheader / Judul Divisi --}}
                <div class="flex items-center space-x-3 mb-6 pb-2 border-b-2 border-red-100">
                    <span class="w-3.5 h-3.5 rounded-full bg-red-600 inline-block shadow-sm"></span>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900">Anggota {{ $div->name }}</h3>
                    <span class="bg-red-50 text-red-700 text-xs font-bold px-2.5 py-0.5 rounded-full border border-red-200">
                        {{ $div->members->count() }} Orang
                    </span>
                </div>

                {{-- Grid Anggota Dalam Divisi --}}
                @if($div->members->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
                        @foreach($div->members as $member)
                            <div class="member-card bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-4 md:p-6 hover:shadow-md transition-shadow duration-200">

                                {{-- Avatar Uncropped (object-fit: contain) --}}
                                <div class="member-avatar mx-auto mb-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}"
                                             alt="{{ $member->name }}"
                                             class="member-avatar-img">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-red-50">
                                            <svg class="w-10 h-10 text-red-200" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info block --}}
                                <div class="member-info">
                                    <h4 class="member-name text-sm md:text-base font-bold text-gray-900 leading-tight">{{ $member->name }}</h4>
                                    <p class="member-position text-red-600 text-xs md:text-sm font-semibold mt-1">{{ $member->position }}</p>
                                    <p class="member-bio text-gray-400 text-xs mt-2">{{ $member->bio ?? '' }}</p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-12 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500 font-medium text-sm md:text-base">Belum ada anggota yang didaftarkan pada divisi ini.</p>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
@else
    <div class="py-16 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300 mb-12">
        <p class="text-gray-600 font-bold text-base md:text-lg mb-1">Belum Ada Divisi yang Dibuat</p>
        <p class="text-gray-400 text-sm">Silakan buat divisi baru melalui Panel Admin -> menu Kelola Divisi.</p>
    </div>
@endif

@endsection

@push('scripts')
<script>
function showDivisionTab(divisionId, btnElement) {
    // 1. Reset active tab buttons
    const tabs = document.querySelectorAll('#division-tabs .division-tab-btn');
    tabs.forEach(tab => tab.classList.remove('active'));
    
    // 2. Set clicked tab active
    if (btnElement) {
        btnElement.classList.add('active');
    }

    // 3. Hide all division panels
    const panels = document.querySelectorAll('.division-panel');
    panels.forEach(panel => panel.classList.add('hidden'));

    // 4. Show selected panel
    const targetPanel = document.getElementById('division-panel-' + divisionId);
    if (targetPanel) {
        targetPanel.classList.remove('hidden');
    }
}
</script>
@endpush
