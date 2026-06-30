@extends('layouts.admin')

@section('page_title', 'Kelola Struktur Anggota')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Anggota</h2>
    <a href="{{ route('admin.members.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        + Tambah Anggota
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-bold text-center w-8 bg-gray-200 rounded-full">{{ $item->order }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($item->photo)
                        <img src="{{ Storage::url($item->photo) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 shadow-sm">NA</div>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->name }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->position }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex items-center space-x-4 mt-2">
                    <a href="{{ route('admin.members.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                    <form action="{{ route('admin.members.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada data anggota yang didaftarkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($members) && $members->hasPages())
<div class="mt-4">
    {{ $members->links() }}
</div>
@endif
@endsection
