@extends('layouts.admin')

@section('page_title', 'Kelola Berita')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Berita</h2>
    <a href="{{ route('admin.news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        + Tambah Berita
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penulis</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Publish</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->title }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">{{ $item->author->name ?? 'Anonim' }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        {{ $item->status === 'published' ? 'text-green-900' : ($item->status === 'draft' ? 'text-gray-900' : 'text-orange-900') }}">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            {{ $item->status === 'published' ? 'bg-green-200' : ($item->status === 'draft' ? 'bg-gray-200' : 'bg-orange-200') }}"></span>
                        <span class="relative capitalize">{{ $item->status }}</span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">
                        {{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}
                    </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex space-x-4">
                    <a href="{{ route('admin.news.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada data berita.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($news) && $news->hasPages())
<div class="mt-4">
    {{ $news->links() }}
</div>
@endif
@endsection
