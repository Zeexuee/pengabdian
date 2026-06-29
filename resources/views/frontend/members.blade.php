@extends('layouts.app')

@section('title', 'Struktur Anggota')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-6">Struktur Pengurus & Anggota</h1>
    <p class="text-gray-600 max-w-2xl">Mengenal lebih dekat para penggerak komunitas yang berdedikasi.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
    @forelse($members as $member)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden text-center p-6 hover:shadow-md transition">
            <div class="w-24 h-24 rounded-full bg-gray-200 mx-auto mb-4 overflow-hidden border-4 border-white shadow-sm">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                @else
                    <!-- Placeholder avatar -->
                    <svg class="w-full h-full text-gray-400 p-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                @endif
            </div>
            <h3 class="text-lg font-bold text-gray-900">{{ $member->name }}</h3>
            <p class="text-blue-600 text-sm font-semibold mb-3">{{ $member->position }}</p>
            @if($member->bio)
                <p class="text-gray-600 text-xs line-clamp-3">{{ $member->bio }}</p>
            @endif
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
            Data struktur anggota belum ditambahkan.
        </div>
    @endforelse
</div>
@endsection
