@extends('layouts.admin')

@section('page_title', 'Selamat Datang')

@section('content')
<!-- Area Selamat Datang -->
<div class="bg-gradient-to-r from-red-700 to-red-800 rounded-2xl shadow-lg text-white p-8 flex flex-col md:flex-row items-center justify-between">
    <div class="mb-4 md:mb-0 max-w-2xl">
        <h3 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}!</h3>
    </div>
    @if($pendingRequests > 0)
    <div>
        <a href="{{ route('admin.join_requests.index') }}" class="inline-block bg-white text-red-800 hover:bg-red-50 font-bold py-3 px-6 rounded-lg shadow transition duration-200 text-sm whitespace-nowrap">
            Tinjau Sekarang &rarr;
        </a>
    </div>
    @endif
</div>
@endsection
