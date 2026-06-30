@extends('layouts.admin')

@section('page_title', 'Kelola Berita')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <h2 class="text-xl font-bold text-gray-800">Daftar Berita</h2>
    
    <div class="flex items-center space-x-4">
        <form action="{{ route('admin.news.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." 
                   class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm w-64">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 transition text-sm font-semibold">
                Cari
            </button>
        </form>
        
        <a href="{{ route('admin.news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition whitespace-nowrap">
            + Tambah Berita
        </a>
    </div>
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
    {{ $news->appends(request()->query())->links() }}
</div>
@endif
@endsection
