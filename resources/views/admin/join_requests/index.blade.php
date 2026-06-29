@extends('layouts.admin')

@section('page_title', 'Kelola Permintaan Gabung')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Permintaan Bergabung</h2>
    <p class="text-gray-600 text-sm mt-1">Tinjau dan proses aplikasi pendaftaran dari calon anggota baru.</p>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Masuk</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pendaftar</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($joinRequests as $request)
            <tr class="hover:bg-gray-50 transition-colors {{ $request->status === 'pending' ? 'bg-yellow-50/30' : '' }}">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $request->created_at->format('d M Y') }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-semibold">{{ $request->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900">{{ $request->email }}</p>
                    <p class="text-gray-500 text-xs">{{ $request->phone_number ?? '-' }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($request->status === 'approved')
                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative">Diterima</span>
                        </span>
                    @elseif($request->status === 'rejected')
                        <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                            <span class="relative">Ditolak</span>
                        </span>
                    @else
                        <span class="relative inline-block px-3 py-1 font-semibold text-yellow-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                            <span class="relative">Pending</span>
                        </span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex space-x-3 items-center">
                    <a href="{{ route('admin.join_requests.show', $request->id) }}" class="text-blue-600 hover:text-blue-900 font-medium border border-blue-200 rounded px-3 py-1 hover:bg-blue-50">Tinjau</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada permintaan bergabung.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($joinRequests->hasPages())
    <div class="mt-4">
        {{ $joinRequests->links() }}
    </div>
@endif
@endsection
