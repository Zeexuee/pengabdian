@extends('layouts.admin')

@section('page_title', 'Kelola Produk')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>

    <div class="flex items-center space-x-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                   class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm w-64">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 transition text-sm font-semibold">
                Cari
            </button>
        </form>

        <a href="{{ route('admin.products.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition whitespace-nowrap">
            + Tambah Produk
        </a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 border-b border-gray-200">
                    @if($product->images->count() > 0)
                        <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}" class="h-14 w-14 object-cover rounded-lg">
                    @else
                        <div class="h-14 w-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                    <p class="text-gray-500 text-xs">{{ $product->images->count() }} gambar</p>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-700">{{ $product->category ?? '-' }}</p>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-700">{{ $product->price ?? '-' }}</p>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight {{ $product->is_active ? 'text-green-900' : 'text-gray-900' }}">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full {{ $product->is_active ? 'bg-green-200' : 'bg-gray-200' }}"></span>
                        <span class="relative">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                    </span>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-red-600 hover:text-red-900 font-semibold">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini beserta semua gambarnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada data produk. <a href="{{ route('admin.products.create') }}" class="text-red-600 hover:underline">Tambah produk pertama</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($products) && $products->hasPages())
<div class="mt-4">
    {{ $products->appends(request()->query())->links() }}
</div>
@endif
@endsection
