<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Sampah Sejahtera Gemilang RW. 06 - @yield('title', 'Beranda')</title>
    
    @hasSection('meta_tags')
        @yield('meta_tags')
    @else
        <meta name="title" content="Bank Sampah Sejahtera Gemilang RW. 06 - @yield('title', 'Beranda')">
        <meta name="description" content="Portal informasi Bank Sampah Sejahtera Gemilang RW. 06.">
    @endif

    <!-- Integrasi Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Script untuk toggle menu mobile & dropdown -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.classList.toggle('hidden');
        }

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function(event) {
            const desktopDropdown = document.getElementById('tentang-dropdown');
            const desktopTrigger = document.getElementById('tentang-trigger');
            if (desktopDropdown && !desktopDropdown.contains(event.target) && !desktopTrigger.contains(event.target)) {
                desktopDropdown.classList.add('hidden');
            }
        });
    </script>
    @stack('styles')
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans text-gray-800">

    <!-- Komponen Navbar Responsif -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative flex items-center h-16">
                <!-- Logo / Nama Komunitas (kiri) -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Bank Sampah" class="h-10 w-auto mr-2">
                        <span class="text-lg font-bold text-blue-600 leading-tight hidden sm:inline">Bank Sampah<br class="hidden lg:block"> Sejahtera Gemilang</span>
                    </a>
                </div>

                <!-- Menu Navigasi Desktop (tengah absolute) -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2 absolute left-1/2 -translate-x-1/2">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('members') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('members') ? 'text-blue-600 font-bold' : '' }}">Struktur Anggota</a>

                    <!-- Dropdown Tentang Kami -->
                    <div class="relative">
                        <button id="tentang-trigger" onclick="toggleDropdown('tentang-dropdown')" class="flex items-center text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition focus:outline-none {{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? 'text-blue-600 font-bold' : '' }}">
                            Tentang Kami
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="tentang-dropdown" class="hidden absolute left-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="{{ route('work_programs') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('work_programs', 'work_programs.*') ? 'text-blue-600 bg-blue-50 font-semibold' : '' }}">Program Kerja</a>
                                <a href="{{ route('news') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition {{ request()->routeIs('news', 'news.*') ? 'text-blue-600 bg-blue-50 font-semibold' : '' }}">Berita</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('educations') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('educations') ? 'text-blue-600 font-bold' : '' }}">Edukasi</a>
                    <a href="{{ route('products') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('products', 'products.*') ? 'text-blue-600 font-bold' : '' }}">Produk Kami</a>
                </div>

                <!-- Tombol Menu Hamburger (Mobile) - kanan -->
                <div class="flex items-center md:hidden ml-auto">
                    <button type="button" onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-expanded="false">
                        <span class="sr-only">Buka menu utama</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu Dropdown Mobile -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-4 pt-2 pb-4 space-y-1 bg-white border-t border-gray-100 shadow-lg">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('home') ? 'text-blue-600 bg-blue-50' : '' }}">Beranda</a>
                <a href="{{ route('members') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('members') ? 'text-blue-600 bg-blue-50' : '' }}">Struktur Anggota</a>

                <!-- Tentang Kami accordion mobile -->
                <div>
                    <button onclick="toggleDropdown('mobile-tentang-submenu')" class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        <span>Tentang Kami</span>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobile-tentang-submenu" class="{{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? '' : 'hidden' }} pl-4 mt-1 space-y-1">
                        <a href="{{ route('work_programs') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('work_programs', 'work_programs.*') ? 'text-blue-600 bg-blue-50 font-semibold' : '' }}">Program Kerja</a>
                        <a href="{{ route('news') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('news', 'news.*') ? 'text-blue-600 bg-blue-50 font-semibold' : '' }}">Berita</a>
                    </div>
                </div>

                <a href="{{ route('educations') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('educations') ? 'text-blue-600 bg-blue-50' : '' }}">Edukasi</a>
                <a href="{{ route('products') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 {{ request()->routeIs('products', 'products.*') ? 'text-blue-600 bg-blue-50' : '' }}">Produk Kami</a>
            </div>
        </div>
    </nav>

    <!-- Kontainer Khusus Flash Messages & Global Error -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm flex justify-between items-center" role="alert">
                <div>
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Gagal!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Terdapat Kesalahan:</p>
                <ul class="list-disc ml-5 mt-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Area Konten Full Width (Contoh: Hero Banner) -->
    @yield('full_width_content')

    <!-- Area Konten Utama Dinamis -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-6">
        @yield('content')
    </main>

    <!-- Komponen Footer Sederhana -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <!-- Branding Footer -->
                <div class="flex justify-center md:justify-start mb-6 md:mb-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Bank Sampah" class="h-10 w-auto mr-3" style="filter: brightness(0) invert(1);">
                    <span class="text-xl font-bold tracking-wider">Bank Sampah Sejahtera Gemilang</span>
                </div>
                <!-- Navigasi Cepat -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8 text-center md:text-left text-sm text-gray-400">
                    <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                    <a href="{{ route('contact') }}" class="hover:text-white transition">Hubungi Kami</a>
                    <a href="{{ route('login') }}" class="hover:text-white transition border-l border-gray-700 pl-8">Admin Login</a>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm text-gray-500 text-center md:text-left">&copy; {{ date('Y') }} Bank Sampah Sejahtera Gemilang RW. 06. Hak cipta dilindungi undang-undang.</p>
                <!-- Ikon Sosial Media (Dummy) -->
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-500 hover:text-white transition">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
