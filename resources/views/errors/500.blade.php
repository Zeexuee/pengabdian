@extends('layouts.app')

@section('title', 'Kesalahan Server (500)')

@section('content')
<div class="min-h-[60vh] flex flex-col items-center justify-center text-center px-4 py-12">
    <div class="mb-8 relative">
        <h1 class="text-9xl font-extrabold text-red-50 select-none">500</h1>
        <div class="absolute inset-0 flex items-center justify-center">
            <svg class="w-16 h-16 text-red-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
    </div>
    
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Kesalahan Server Internal</h2>
    <p class="text-gray-500 mb-8 max-w-md mx-auto text-lg leading-relaxed">
        Tampaknya ada sedikit gangguan teknis pada sistem kami. Tim administrator sedang berupaya memperbaikinya. Silakan coba kembali dalam beberapa saat.
    </p>
    
    <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Kembali ke Beranda
    </a>
</div>
@endsection
