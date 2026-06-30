@extends('layouts.app')

@section('title', 'Edukasi')

@section('content')
<div class="mb-12">
    <h1 class="text-3xl font-bold text-gray-900 border-l-4 border-blue-600 pl-4 mb-6">Pusat Edukasi</h1>
    <p class="text-gray-600 max-w-2xl">Materi pembelajaran, tutorial, dan artikel informatif untuk meningkatkan wawasan.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    @forelse($educations as $edu)
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition flex flex-col">
            @if($edu->thumbnail)
                <img src="{{ asset('storage/' . $edu->thumbnail) }}" alt="{{ $edu->title }}" class="w-full h-56 object-cover">
            @endif
            <div class="p-6 flex-grow flex flex-col">
                <h2 class="text-xl font-bold text-gray-900 mb-3">{{ $edu->title }}</h2>
                <div class="text-gray-600 text-sm mb-6 flex-grow">{!! Str::limit(strip_tags($edu->content), 150) !!}</div>
                
                @if($edu->video_url)
                    <a href="{{ $edu->video_url }}" target="_blank" class="inline-flex items-center text-red-600 hover:text-red-800 font-semibold mb-4">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                        Tonton Video
                    </a>
                @endif
                
                <a href="{{ route('educations.detail', $edu->slug) }}" class="inline-block px-4 py-2 bg-gray-100 text-gray-800 rounded-md hover:bg-gray-200 transition text-sm font-semibold text-center mt-auto">Mulai Belajar</a>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 text-gray-500 bg-gray-50 rounded-lg border border-dashed">
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
