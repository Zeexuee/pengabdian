@extends('layouts.admin')

@section('page_title', 'Dasbor Utama')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">Ringkasan Sistem</h2>
    <p class="text-gray-500 text-sm mt-1">Pantau statistik utama dari berbagai modul pada CMS Anda hari ini.</p>
</div>

<!-- Grid Metrik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Metrik 1: Total Berita -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Berita</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalNews) }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9l-2-2m-2-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-3l-2-2z"></path></svg>
        </div>
    </div>

    <!-- Metrik 2: Total Anggota -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Anggota</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($totalMembers) }}</h3>
        </div>
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
    </div>

    <!-- Metrik 3: Program Kerja Aktif -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Program Berjalan</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($activePrograms) }}</h3>
        </div>
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-full flex items-center justify-center shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
    </div>

    <!-- Metrik 4: Permintaan Gabung Pending -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Request Pending</p>
            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($pendingRequests) }}</h3>
        </div>
        <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center shadow-inner">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

</div>

<!-- Area Selamat Datang (Tambahan) -->
<div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-2xl shadow-lg text-white p-8 mb-8 flex flex-col md:flex-row items-center justify-between">
    <div class="mb-4 md:mb-0 max-w-2xl">
        <h3 class="text-2xl font-bold mb-2">Selamat Datang Kembali, {{ auth()->user()->name ?? 'Admin' }}!</h3>
        <p class="text-blue-100 font-light">
            Sistem merangkum bahwa terdapat <strong>{{ $pendingRequests }}</strong> permintaan bergabung baru yang menantikan peninjauan Anda. Pastikan untuk selalu memantau program kerja yang sedang berjalan untuk memastikan kelancaran aktivitas komunitas.
        </p>
    </div>
    @if($pendingRequests > 0)
    <div>
        <a href="{{ route('admin.join_requests.index') }}" class="inline-block bg-white text-blue-800 hover:bg-blue-50 font-bold py-3 px-6 rounded-lg shadow transition duration-200">
            Tinjau Sekarang &rarr;
        </a>
    </div>
    @endif
</div>
@endsection
