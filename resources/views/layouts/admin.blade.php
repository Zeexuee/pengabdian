<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - CMS Komunitas</title>
    <!-- Integrasi Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex">

    <!-- Sidebar (Kiri - Fixed) -->
    <aside class="bg-gray-800 text-white w-64 min-h-screen fixed left-0 top-0 overflow-y-auto shadow-lg z-20">
        <div class="p-6 flex items-center justify-center border-b border-gray-700">
            <span class="text-2xl font-bold tracking-wider">CMS Komunitas</span>
        </div>
        <nav class="mt-6 px-4">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main Menu</p>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('admin.members.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.members.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Struktur Anggota</a>
                </li>
                <li>
                    <a href="{{ route('admin.work-programs.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.work-programs.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Program Kerja</a>
                </li>
                <li>
                    <a href="{{ route('admin.educations.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.educations.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Edukasi</a>
                </li>
                <li>
                    <a href="{{ route('admin.news.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.news.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Berita</a>
                </li>
            </ul>

            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Interaksi Publik</p>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('admin.contacts.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Kontak</a>
                </li>
                <li>
                    <a href="{{ route('admin.join_requests.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-700 transition-colors {{ request()->routeIs('admin.join_requests.*') ? 'bg-gray-700 text-white' : 'text-gray-300' }}">Permintaan Gabung</a>
                </li>
            </ul>

            <div class="mt-8 border-t border-gray-700 pt-6">
                <!-- Form Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-400 hover:bg-gray-700 hover:text-red-300 rounded-md transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content (Kanan - Sisakan ruang 64 atau 256px untuk sidebar) -->
    <main class="ml-64 flex-1 flex flex-col min-h-screen">
        
        <!-- Top Header Bar (Optional, for mobile menu or user profile info) -->
        <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
            <h1 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
            <div class="text-gray-600">
                Halo, <span class="font-bold">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
        </header>

        <!-- Area Konten Aktual -->
        <div class="flex-1 p-8">
            
            <!-- Tangkapan Flash Messages (Sukses / Error) -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Validasi Error Form (global catch) -->
            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                    <p class="font-bold">Terdapat kesalahan:</p>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Yield Konten Utama -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                @yield('content')
            </div>

        </div>
        
    </main>

</body>
</html>
