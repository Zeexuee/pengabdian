@extends('layouts.admin')

@section('page_title', 'Kelola Berita')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Berita</h2>
        <p class="text-xs text-gray-500 mt-1">Seret baris (drag &amp; drop) untuk mengubah urutan tampilan berita di website.</p>
    </div>
    
    <div class="flex items-center space-x-4">
        <form action="{{ route('admin.news.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." 
                   class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm w-64">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 transition text-sm font-semibold">
                Cari
            </button>
        </form>
        
        <a href="{{ route('admin.news.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition whitespace-nowrap text-sm">
            + Tambah Berita
        </a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8"></th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Penulis</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Publish</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-news">
            @forelse($news as $item)
            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 cursor-move">
                <td class="px-4 py-4 border-b border-gray-200 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </td>
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
                        {{ $item->published_at ? $item->published_at->format('d M Y H:i') : '-' }}
                    </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex items-center space-x-3">
                    <a href="{{ route('admin.news.detail', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-xs bg-blue-50 border border-blue-200 px-2.5 py-1 rounded">Edit Details</a>
                    <a href="{{ route('admin.news.edit', $item->id) }}" class="text-red-600 hover:text-red-900 font-semibold text-xs">Edit</a>
                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 font-semibold text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    var newsEl = document.getElementById('sortable-news');
    if (newsEl) {
        Sortable.create(newsEl, {
            animation: 150,
            ghostClass: 'bg-red-50',
            onEnd: function () {
                var items = [];
                newsEl.querySelectorAll('tr[data-id]').forEach(function (row, index) {
                    items.push({ id: row.getAttribute('data-id'), order: index + 1 });
                });
                fetch('{{ route("admin.news.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ orders: items })
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        newsEl.style.transition = 'opacity 0.2s';
                        newsEl.style.opacity = '0.5';
                        setTimeout(() => newsEl.style.opacity = '1', 300);
                    }
                });
            }
        });
    }
});
</script>
@endpush
