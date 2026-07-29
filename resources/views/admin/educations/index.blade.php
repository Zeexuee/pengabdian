@extends('layouts.admin')

@section('page_title', 'Kelola Materi Edukasi')

@section('content')
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Edukasi</h2>
        <p class="text-xs text-gray-500 mt-1">Seret baris (drag &amp; drop) untuk mengubah urutan tampilan edukasi di website.</p>
    </div>
    
    <div class="flex items-center space-x-4">
        <form action="{{ route('admin.educations.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari edukasi..." 
                   class="border border-gray-300 rounded-l-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm w-64">
            <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-r-md border border-l-0 border-gray-300 transition text-sm font-semibold">
                Cari
            </button>
        </form>

        <a href="{{ route('admin.educations.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition whitespace-nowrap text-sm">
            + Tambah Materi
        </a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8"></th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thumbnail</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul Materi</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Video Utama</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status Publikasi</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-educations">
            @forelse($educations as $item)
            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 cursor-move">
                <td class="px-4 py-4 border-b border-gray-200 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($item->thumbnail)
                        <img src="{{ Storage::url($item->thumbnail) }}" alt="{{ $item->title }}" class="w-16 h-12 rounded object-cover shadow-sm bg-slate-900">
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
                        <a href="{{ $item->video_url }}" target="_blank" class="text-red-600 hover:underline text-xs">Lihat Video</a>
                    @else
                        <span class="text-gray-400 text-xs">Tidak ada</span>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        {{ $item->is_published ? 'text-green-900' : 'text-orange-900' }}">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            {{ $item->is_published ? 'bg-green-200' : 'bg-orange-200' }}"></span>
                        <span class="relative text-xs">{{ $item->is_published ? 'Dipublikasikan' : 'Draf' }}</span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex items-center space-x-3 mt-2">
                    <a href="{{ route('admin.educations.detail', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold text-xs bg-blue-50 border border-blue-200 px-2.5 py-1 rounded">Edit Details</a>
                    <a href="{{ route('admin.educations.edit', $item->id) }}" class="text-red-600 hover:text-red-900 font-semibold text-xs">Edit</a>
                    <form action="{{ route('admin.educations.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi edukasi ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 font-semibold text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    var eduEl = document.getElementById('sortable-educations');
    if (eduEl) {
        Sortable.create(eduEl, {
            animation: 150,
            ghostClass: 'bg-red-50',
            onEnd: function () {
                var items = [];
                eduEl.querySelectorAll('tr[data-id]').forEach(function (row, index) {
                    items.push({ id: row.getAttribute('data-id'), order: index + 1 });
                });
                fetch('{{ route("admin.educations.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ orders: items })
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        eduEl.style.transition = 'opacity 0.2s';
                        eduEl.style.opacity = '0.5';
                        setTimeout(() => eduEl.style.opacity = '1', 300);
                    }
                });
            }
        });
    }
});
</script>
@endpush
