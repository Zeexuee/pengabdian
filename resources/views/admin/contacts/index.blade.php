@extends('layouts.admin')

@section('page_title', 'Kotak Masuk Pesan')

@section('content')
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Pesan Masuk</h2>
    <p class="text-gray-600 text-sm mt-1">Kelola dan baca pesan yang dikirimkan oleh pengunjung melalui form kontak publik.</p>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tgl Masuk</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Pengirim</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subjek</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
            <tr class="hover:bg-gray-50 transition-colors {{ !$contact->is_read ? 'bg-blue-50/50' : '' }}">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $contact->created_at->format('d M Y, H:i') }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-semibold">{{ $contact->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $contact->email }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap max-w-xs truncate">{{ $contact->subject }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($contact->is_read)
                        <span class="relative inline-block px-3 py-1 font-semibold text-gray-700 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                            <span class="relative">Sudah Dibaca</span>
                        </span>
                    @else
                        <span class="relative inline-block px-3 py-1 font-semibold text-blue-800 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-blue-200 opacity-50 rounded-full"></span>
                            <span class="relative">Belum Dibaca</span>
                        </span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex space-x-3 items-center">
                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">Buka Pesan</a>
                    <span class="text-gray-300">|</span>
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Tidak ada pesan masuk.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($contacts->hasPages())
    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
@endif
@endsection
