@extends('layouts.admin')

@section('page_title', 'Kelola Divisi & Hero Banner')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Divisi Organisasi</h2>
        <p class="text-gray-500 text-sm mt-1">Tambah divisi baru, atur urutan tampil, edit nama divisi, serta upload gambar Hero Banner untuk masing-masing divisi.</p>
    </div>
    <a href="{{ route('admin.divisions.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm flex items-center">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        + Tambah Divisi Baru
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8"></th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hero Banner</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Divisi</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Anggota</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-divisions">
            @forelse($divisions as $item)
            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 cursor-move">
                <td class="px-4 py-4 border-b border-gray-200 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    @if($item->banner_image)
                        <img src="{{ Storage::url($item->banner_image) }}" alt="{{ $item->name }}" class="w-32 h-16 object-cover rounded shadow-sm border border-gray-200">
                    @else
                        <div class="w-32 h-16 bg-gray-100 border border-dashed border-gray-300 rounded flex items-center justify-center text-xs text-gray-400 font-medium">
                            Belum Ada Banner
                        </div>
                    @endif
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-bold text-base">{{ $item->name }}</p>
                    @if($item->description)
                        <p class="text-gray-500 text-xs mt-0.5 max-w-md line-clamp-1">{{ $item->description }}</p>
                    @endif
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <span class="inline-block bg-red-50 text-red-700 border border-red-200 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $item->members_count }} Anggota
                    </span>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.divisions.edit', $item->id) }}" class="text-red-600 hover:text-red-900 font-semibold text-sm">Edit</a>
                        <form action="{{ route('admin.divisions.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus divisi {{ $item->name }}? Seluruh anggota di divisi ini akan kehilangan referensi divisinya.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 font-semibold text-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada divisi yang dibuat. Klik tombol <strong>+ Tambah Divisi Baru</strong> di atas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';
    var el = document.getElementById('sortable-divisions');
    if (el) {
        Sortable.create(el, {
            animation: 150,
            ghostClass: 'bg-red-50',
            onEnd: function () {
                var items = [];
                el.querySelectorAll('tr[data-id]').forEach(function (row, index) {
                    items.push({ id: row.getAttribute('data-id'), order: index + 1 });
                });
                fetch('{{ route("admin.divisions.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ orders: items })
                });
            }
        });
    }
});
</script>
@endpush
