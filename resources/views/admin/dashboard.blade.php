@extends('layouts.admin')

@section('page_title', 'Dashboard Utama')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Box 1 -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-2">Total Berita</h3>
        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\News::count() }}</p>
    </div>
    
    <!-- Stat Box 2 -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
        <h3 class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-2">Total Anggota</h3>
        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Member::count() }}</p>
    </div>

    <!-- Stat Box 3 -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-2">Program Kerja</h3>
        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\WorkProgram::count() }}</p>
    </div>

    <!-- Stat Box 4 -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-orange-500">
        <h3 class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-2">Permintaan Gabung (Pending)</h3>
        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\JoinRequest::where('status', 'pending')->count() }}</p>
    </div>
</div>

<div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
    <h2 class="text-xl font-bold text-blue-800 mb-3">Selamat Datang di Panel Admin CMS Komunitas!</h2>
    <p class="text-blue-700">
        Anda telah berhasil masuk ke sistem pengelola konten. Gunakan menu navigasi di bilah kiri untuk mengelola berbagai data seperti berita, program kerja, hingga merespons pesan masuk dan permintaan bergabung dari pengunjung publik.
    </p>
    <p class="text-blue-700 mt-2">
        Semua perubahan yang Anda lakukan di sini akan langsung tercermin di halaman publik website.
    </p>
</div>
@endsection
