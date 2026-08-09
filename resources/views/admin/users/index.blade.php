@extends('layouts.admin')

@section('page_title', 'Pengaturan Admin & Manajemen User')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pengguna & Admin</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola hak akses pengguna, tambah akun baru, dan perbarui kata sandi.</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition duration-200 text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Tambah Akun Baru
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex flex-col md:flex-row gap-4 items-center justify-between">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                    class="w-full pl-10 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="w-full md:w-48">
                <select name="role" class="w-full py-2 px-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                    <option value="">Semua Peran</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-medium transition duration-150">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-medium transition duration-150">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200 bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Peran</th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-red-100 text-red-700 font-bold flex items-center justify-center mr-3 text-sm border border-red-200">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 flex items-center gap-2">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="px-2 py-0.5 text-xs bg-green-100 text-green-700 font-semibold rounded-full border border-green-200">
                                                Akun Anda
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 border border-red-200">
                                    Admin
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at ? $user->created_at->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Tombol Ganti Password -->
                                <button type="button" 
                                    onclick="openPasswordModal('{{ $user->id }}', '{{ addslashes($user->name) }}')"
                                    class="px-3 py-1.5 bg-amber-50 text-amber-700 hover:bg-amber-100 rounded-md text-xs font-medium border border-amber-200 transition duration-150 flex items-center gap-1"
                                    title="Ganti Password">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"></path>
                                    </svg>
                                    Ganti Password
                                </button>

                                <!-- Tombol Edit -->
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                    class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md text-xs font-medium border border-blue-200 transition duration-150 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </a>

                                <!-- Tombol Hapus -->
                                @if($user->id === auth()->id())
                                    <button disabled 
                                        class="px-3 py-1.5 bg-gray-100 text-gray-400 rounded-md text-xs font-medium cursor-not-allowed border border-gray-200" 
                                        title="Anda tidak bisa menghapus akun Anda sendiri">
                                        Hapus
                                    </button>
                                @else
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }}? Aksi ini tidak dapat dibatalkan.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 rounded-md text-xs font-medium border border-red-200 transition duration-150 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="text-base font-medium">Tidak ada data pengguna ditemukan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Modal Quick Ganti Password -->
<div id="passwordModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <div class="bg-gray-800 text-white px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"></path>
                </svg>
                Ganti Kata Sandi
            </h3>
            <button type="button" onclick="closePasswordModal()" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="passwordForm" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <p class="text-sm text-gray-600">
                Ubah kata sandi untuk pengguna <span id="modalUserName" class="font-bold text-gray-900"></span>.
            </p>

            <div>
                <label for="modal_password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi Baru <span class="text-red-500">*</span></label>
                <input type="password" name="password" id="modal_password" required minlength="8" placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div>
                <label for="modal_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" id="modal_password_confirmation" required minlength="8" placeholder="Ulangi kata sandi baru"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closePasswordModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-medium transition">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium shadow transition">
                    Simpan Kata Sandi
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openPasswordModal(userId, userName) {
    const modal = document.getElementById('passwordModal');
    const form = document.getElementById('passwordForm');
    const nameSpan = document.getElementById('modalUserName');
    
    // Set Action URL
    form.action = `/admin/users/${userId}/password`;
    nameSpan.textContent = userName;
    
    // Reset Form
    document.getElementById('modal_password').value = '';
    document.getElementById('modal_password_confirmation').value = '';
    
    modal.classList.remove('hidden');
}

function closePasswordModal() {
    const modal = document.getElementById('passwordModal');
    modal.classList.add('hidden');
}
</script>
@endpush
@endsection
