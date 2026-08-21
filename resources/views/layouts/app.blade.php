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
        document.addEventListener('click', function (event) {
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
                        <img src="{{ asset('images/logo-baru.png') }}" alt="Logo Bank Sampah" class="h-10 w-auto mr-2">
                        <span class="text-lg font-bold text-black leading-tight hidden sm:inline">Bank Sampah<br
                                class="hidden lg:block"> Sejahtera Gemilang</span>
                    </a>
                </div>

                <!-- Menu Navigasi Desktop (tengah absolute) -->
                <div class="hidden md:flex items-center space-x-1 lg:space-x-2 absolute left-1/2 -translate-x-1/2">
                    <a href="{{ route('home') }}"
                        class="text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('home') ? 'text-red-600 font-bold' : '' }}">Beranda</a>
                    <a href="{{ route('members') }}"
                        class="text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('members') ? 'text-red-600 font-bold' : '' }}">Struktur
                        Anggota</a>

                    <!-- Dropdown Tentang Kami -->
                    <div class="relative">
                        <button id="tentang-trigger" onclick="toggleDropdown('tentang-dropdown')"
                            class="flex items-center text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition focus:outline-none {{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? 'text-red-600 font-bold' : '' }}">
                            Tentang Kami
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="tentang-dropdown"
                            class="hidden absolute left-0 top-full mt-1 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                <a href="{{ route('work_programs') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition {{ request()->routeIs('work_programs', 'work_programs.*') ? 'text-red-600 bg-red-50 font-semibold' : '' }}">Program
                                    Kerja</a>
                                <a href="{{ route('news') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition {{ request()->routeIs('news', 'news.*') ? 'text-red-600 bg-red-50 font-semibold' : '' }}">Berita</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('educations') }}"
                        class="text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('educations') ? 'text-red-600 font-bold' : '' }}">Edukasi</a>
                    <a href="{{ route('products') }}"
                        class="text-gray-600 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('products', 'products.*') ? 'text-red-600 font-bold' : '' }}">Produk
                        Kami</a>
                </div>

                <!-- Logo Disain & Logo Mercu (Kanan Navbar) -->
                <div class="flex items-center space-x-2 sm:space-x-3 ml-auto">
                    <img src="{{ asset('images/logo_disain.png') }}" alt="Logo Disain" class="h-8 md:h-10 w-auto object-contain">
                    <img src="{{ asset('images/logo-mercu.png') }}" alt="Logo Mercu Buana" class="h-8 md:h-10 w-auto object-contain">

                    <!-- Tombol Menu Hamburger (Mobile) -->
                    <div class="flex items-center md:hidden ml-1">
                        <button type="button" onclick="toggleMobileMenu()"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500"
                            aria-expanded="false">
                            <span class="sr-only">Buka menu utama</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Dropdown Mobile -->
        <div class="md:hidden hidden" id="mobile-menu">
            <div class="px-4 pt-2 pb-4 space-y-1 bg-white border-t border-gray-100 shadow-lg">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('home') ? 'text-red-600 bg-red-50' : '' }}">Beranda</a>
                <a href="{{ route('members') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('members') ? 'text-red-600 bg-red-50' : '' }}">Struktur
                    Anggota</a>

                <!-- Tentang Kami accordion mobile -->
                <div>
                    <button onclick="toggleDropdown('mobile-tentang-submenu')"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? 'text-red-600 bg-red-50' : '' }}">
                        <span>Tentang Kami</span>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="mobile-tentang-submenu"
                        class="{{ request()->routeIs('work_programs', 'work_programs.*', 'news', 'news.*') ? '' : 'hidden' }} pl-4 mt-1 space-y-1">
                        <a href="{{ route('work_programs') }}"
                            class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('work_programs', 'work_programs.*') ? 'text-red-600 bg-red-50 font-semibold' : '' }}">Program
                            Kerja</a>
                        <a href="{{ route('news') }}"
                            class="block px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('news', 'news.*') ? 'text-red-600 bg-red-50 font-semibold' : '' }}">Berita</a>
                    </div>
                </div>

                <a href="{{ route('educations') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('educations') ? 'text-red-600 bg-red-50' : '' }}">Edukasi</a>
                <a href="{{ route('products') }}"
                    class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-50 {{ request()->routeIs('products', 'products.*') ? 'text-red-600 bg-red-50' : '' }}">Produk
                    Kami</a>
            </div>
        </div>
    </nav>

    <!-- Kontainer Khusus Flash Messages & Global Error -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm flex justify-between items-center"
                role="alert">
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

    <!-- Footer Simple & Clean -->
    <footer class="bg-slate-900 text-slate-400 border-t-2 border-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Grid Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

                <!-- Kolom 1: Logo & Branding -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo-baru.png') }}" alt="Logo Bank Sampah" class="h-10 w-auto">
                        <div>
                            <span class="text-base font-bold text-white block leading-tight">Bank Sampah</span>
                            <span class="text-xs font-semibold text-red-500 tracking-wider uppercase block">Sejahtera
                                Gemilang</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                        Website Resmi dan dikelola RW. 006 Kelurahan Pakulonan Barat, Kecamatan Tangerang, Kota
                        Tangerang, Provinsi Banten.
                    </p>
                </div>

                <!-- Kolom 2: Tautan Cepat -->
                <div>
                    <h3 class="text-xs font-bold text-white tracking-wider uppercase mb-4">
                        Tautan Cepat
                    </h3>
                    <ul class="grid grid-cols-2 gap-2 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-red-500 transition-colors">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('members') }}" class="hover:text-red-500 transition-colors">Struktur
                                Anggota</a>
                        </li>
                        <li>
                            <a href="{{ route('work_programs') }}" class="hover:text-red-500 transition-colors">Program
                                Kerja</a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}" class="hover:text-red-500 transition-colors">Berita</a>
                        </li>
                        <li>
                            <a href="{{ route('educations') }}" class="hover:text-red-500 transition-colors">Edukasi</a>
                        </li>
                        <li>
                            <a href="{{ route('products') }}" class="hover:text-red-500 transition-colors">Produk</a>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: Kontak & Media Sosial -->
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-white tracking-wider uppercase">
                        Kontak Kami
                    </h3>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="leading-relaxed">
                            RW. 006, Sejahtera Gemilang, Pakulonan Barat, Tangerang Utara, Banten
                        </li>
                        <li>
                            WA: <a href="https://wa.me/6282114425126" target="_blank"
                                class="hover:text-red-500 transition-colors">+6282-1144-25126</a>
                        </li>
                        <li>
                            Email: <a href="mailto:fathanfarizi@fathan.lt"
                                class="hover:text-red-500 transition-colors">fathanfarizi@fathan.lt</a>
                        </li>
                    </ul>

                    <!-- Media Sosial Icons -->
                    <div class="flex space-x-4 pt-2">
                        <a href="https://www.instagram.com/rw.06_pakbar?igsh=YnVlbTZ0NXQzZ2Jy"
                            class="text-slate-400 hover:text-red-500 transition-colors">
                            <span class="sr-only">Instagram</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.008 3.885.058 1.02.047 1.745.208 2.37.453a4.125 4.125 0 0 1 1.487.967 4.125 4.125 0 0 1 .967 1.487c.245.624.406 1.349.453 2.37.05 1.1.058 1.455.058 3.885s-.008 2.784-.058 3.885c-.047 1.02-.208 1.745-.453 2.37a4.125 4.125 0 0 1-.967 1.487 4.125 4.125 0 0 1-1.487.967c-.624.245-1.349.406-2.37.453-1.1.05-1.455.058-3.885.058s-2.784-.008-3.885-.058c-1.02-.047-1.745-.208-2.37-.453a4.125 4.125 0 0 1-1.487-.967 4.125 4.125 0 0 1-.967-1.487c-.245-.624-.406-1.349-.453-2.37C2.008 14.855 2 14.5 2 12.063c0-2.43.008-2.784.058-3.885.047-1.02.208-1.745.453-2.37a4.125 4.125 0 0 1 .967-1.487 4.125 4.125 0 0 1 1.487-.967c.624-.245 1.349-.406 2.37-.453 1.1-.05 1.455-.058 3.885-.058zm-.215 5.838a4.228 4.228 0 1 0 0 8.456 4.228 4.228 0 0 0 0-8.456zm0 7.013a2.785 2.785 0 1 1 0-5.57 2.785 2.785 0 0 1 0 5.57zm5.278-7.859a.98.98 0 1 0 0 1.96.98.98 0 0 0 0-1.96z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Admin Login -->
            <div
                class="pt-6 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 space-y-2 sm:space-y-0">
                <p>&copy; {{ date('Y') }} Bank Sampah Sejahtera Gemilang RW. 006 Pakulonan Barat. Hak Cipta Dilindungi.
                </p>
                <div class="flex space-x-4">

                    <a href="{{ route('login') }}" class="hover:text-red-500 transition-colors">Admin Login</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>