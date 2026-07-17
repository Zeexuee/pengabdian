@extends('layouts.admin')

@section('page_title', 'Kelola Pesan Kontak')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Pesan Kontak</h2>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subjek</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $item)
            <tr class="hover:bg-gray-50 {{ !$item->is_read ? 'bg-red-50' : '' }}">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->email }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->subject }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        {{ $item->is_read ? 'text-green-900' : 'text-orange-900' }}">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            {{ $item->is_read ? 'bg-green-200' : 'bg-orange-200' }}"></span>
                        <span class="relative capitalize">{{ $item->is_read ? 'Sudah Dibaca' : 'Belum Dibaca' }}</span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex space-x-4">
                    <a href="{{ route('admin.contacts.show', $item->id) }}" class="text-red-600 hover:text-red-900 font-semibold">Detail</a>
                    <form action="{{ route('admin.contacts.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada pesan masuk.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($contacts) && $contacts->hasPages())
<div class="mt-4">
    {{ $contacts->links() }}
</div>
@endif
@endsection
