@extends('layouts.admin')

@section('page_title', 'Kelola Permintaan Gabung')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Pendaftar</h2>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email/Telepon</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($joinRequests as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->email }}</p>
                    <p class="text-gray-500 whitespace-no-wrap text-xs">{{ $item->phone_number }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        @if($item->status === 'approved') text-green-900 
                        @elseif($item->status === 'rejected') text-red-900 
                        @else text-orange-900 @endif">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            @if($item->status === 'approved') bg-green-200 
                            @elseif($item->status === 'rejected') bg-red-200 
                            @else bg-orange-200 @endif"></span>
                        <span class="relative capitalize">{{ $item->status }}</span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">
                        {{ $item->created_at->format('d M Y') }}
                    </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex space-x-4">
                    <a href="{{ route('admin.join_requests.show', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Detail</a>
                    <form action="{{ route('admin.join_requests.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada permintaan gabung.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($joinRequests) && $joinRequests->hasPages())
<div class="mt-4">
    {{ $joinRequests->links() }}
</div>
@endif
@endsection
