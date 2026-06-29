@extends('layouts.app')

@section('title', 'Program Kerja')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-6">Program Kerja Komunitas</h1>
    <p class="text-gray-600 max-w-2xl">Daftar kegiatan dan inisiatif yang kami rencanakan dan sedang jalankan.</p>
</div>

<div class="space-y-8">
    @forelse($workPrograms as $program)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 md:p-8 flex flex-col md:flex-row gap-6 hover:shadow-md transition">
            @if($program->image)
                <div class="md:w-1/3 flex-shrink-0">
                    <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="w-full h-48 object-cover rounded-md">
                </div>
            @endif
            
            <div class="{{ $program->image ? 'md:w-2/3' : 'w-full' }} flex flex-col justify-center">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-xl font-bold text-gray-900">{{ $program->title }}</h2>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ $program->status === 'completed' ? 'bg-green-100 text-green-800' : ($program->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ ucfirst($program->status) }}
                    </span>
                </div>
                
                <p class="text-sm text-gray-500 mb-4">
                    Jadwal: {{ $program->start_date ? $program->start_date->format('d M Y') : 'TBA' }} 
                    s/d {{ $program->end_date ? $program->end_date->format('d M Y') : 'TBA' }}
                </p>
                
                <p class="text-gray-600">{{ $program->description }}</p>
            </div>
        </div>
    @empty
        <div class="text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
            Belum ada data program kerja.
        </div>
    @endforelse
</div>
@endsection
