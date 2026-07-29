@extends('layouts.admin')

@section('page_title', 'Kelola Struktur Anggota')

@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Anggota Organisasi</h2>
        <p class="text-gray-500 text-sm mt-1">Kelola data anggota dan posisi jabatan. Seret baris untuk mengubah urutan tampil anggota dalam divisi masing-masing.</p>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.divisions.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded shadow-sm border border-gray-300 transition text-sm flex items-center">
            <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Kelola Divisi &amp; Hero Banner
        </a>
        <a href="{{ route('admin.members.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm flex items-center">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            + Tambah Anggota
        </a>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8"></th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Divisi</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-members">
            @forelse($members as $item)
            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 cursor-move">
                <td class="px-4 py-4 border-b border-gray-200 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    @if($item->photo)
                        <img src="{{ Storage::url($item->photo) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    @else
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 text-xs font-bold shadow-sm">NA</div>
                    @endif
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-semibold">{{ $item->name }}</p>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-700">{{ $item->position }}</p>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <span class="inline-block bg-red-50 text-red-700 border border-red-200 text-xs font-semibold px-2.5 py-1 rounded-full">
                        {{ $item->division->name ?? $item->division ?? 'Tanpa Divisi' }}
                    </span>
                </td>
                <td class="px-4 py-4 border-b border-gray-200 text-sm">
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.members.edit', $item->id) }}" class="text-red-600 hover:text-red-900 font-semibold">Edit</a>
                        <form action="{{ route('admin.members.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?');">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    // ── Sortable: Members table rows ────────────────────────────────
    var membersEl = document.getElementById('sortable-members');
    if (membersEl) {
        Sortable.create(membersEl, {
            animation: 150,
            ghostClass: 'bg-red-50',
            onEnd: function () {
                var items = [];
                membersEl.querySelectorAll('tr[data-id]').forEach(function (row, index) {
                    items.push({ id: row.getAttribute('data-id'), order: index + 1 });
                });
                fetch('{{ route("admin.members.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ orders: items })
                }).then(r => r.json()).then(data => {
                    if (data.success) {
                        membersEl.style.transition = 'opacity 0.2s';
                        membersEl.style.opacity = '0.5';
                        setTimeout(() => membersEl.style.opacity = '1', 300);
                    }
                });
            }
        });
    }
});
</script>
@endpush
