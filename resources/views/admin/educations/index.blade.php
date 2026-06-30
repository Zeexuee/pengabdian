@extends('layouts.admin')

@section('page_title', 'Kelola Materi Edukasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Edukasi</h2>
    <a href="{{ route('admin.educations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        + Tambah Materi
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thumbnail</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Materi</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Video</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Publikasi</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($educations as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($item->thumbnail)
                        <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" class="w-16 h-12 rounded object-cover shadow-sm">
                    @else
                        <div class="w-16 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-xs shadow-sm">No Image</div>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->title }}</p>
                    <p class="text-gray-500 text-xs mt-1">/edukasi/{{ $item->slug }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($item->video_url)
                        <a href="{{ $item->video_url }}" target="_blank" class="text-blue-600 hover:underline">Lihat Video</a>
                    @else
                        <span class="text-gray-400">Tidak ada</span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        {{ $item->is_published ? 'text-green-900' : 'text-orange-900' }}">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            {{ $item->is_published ? 'bg-green-200' : 'bg-orange-200' }}"></span>
                        <span class="relative">{{ $item->is_published ? 'Dipublikasikan' : 'Draf' }}</span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex items-center space-x-4 mt-2">
                    <a href="{{ route('admin.educations.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                    <form action="{{ route('admin.educations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi edukasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada materi edukasi yang ditambahkan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($educations) && $educations->hasPages())
<div class="mt-4">
    {{ $educations->links() }}
</div>
@endif
@endsection
