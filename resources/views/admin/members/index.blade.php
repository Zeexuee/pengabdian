@extends('layouts.admin')

@section('page_title', 'Kelola Struktur Anggota')

@section('content')

{{-- ═══════════════════════════════════════════════ --}}
{{-- PANEL 1: GAMBAR TAMBAHAN (SECTIONS)             --}}
{{-- ═══════════════════════════════════════════════ --}}
<div class="mb-10">
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-800">Gambar Tambahan Halaman</h2>
        <p class="text-gray-500 text-sm mt-1">
            Tambahkan gambar yang tampil di halaman Struktur Anggota. Pilih posisi: <strong>Di Atas</strong> (sebelum daftar anggota) atau <strong>Di Bawah</strong> (setelah daftar anggota). Seret gambar untuk mengubah urutan dalam masing-masing grup.
        </p>
    </div>

    {{-- Form Upload --}}
    <div class="bg-white p-4 rounded-lg shadow-sm border mb-6">
        <form action="{{ route('admin.members.sections.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="file" name="images[]" multiple accept="image/*"
                    class="flex-grow block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100"
                    required>
                <select name="position" class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:ring-red-500 focus:border-red-500 flex-shrink-0">
                    <option value="above">⬆ Di Atas Daftar Anggota</option>
                    <option value="below" selected>⬇ Di Bawah Daftar Anggota</option>
                </select>
                <button type="submit" class="flex-shrink-0 px-5 py-2 bg-red-600 text-white rounded font-bold hover:bg-red-700 transition text-sm">
                    Upload
                </button>
            </div>
        </form>
    </div>

    {{-- ── Gambar Di Atas ──────────────────────────────── --}}
    @php $sectionsAbove = $sections->where('position', 'above'); @endphp
    <div class="mb-5">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-bold text-white bg-red-500 px-2 py-0.5 rounded">⬆ Di Atas Daftar Anggota</span>
            <span class="text-xs text-gray-400">{{ $sectionsAbove->count() }} gambar</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 min-h-[80px] bg-red-50/50 border-2 border-dashed border-red-200 rounded-lg p-2" id="sortable-sections-above">
            @forelse($sectionsAbove as $sec)
                <div data-id="{{ $sec->id }}" class="relative group rounded-lg overflow-hidden border shadow-sm cursor-move bg-white">
                    <img src="{{ asset('storage/' . $sec->image) }}" class="w-full h-28 object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <form action="{{ route('admin.members.sections.destroy', $sec->id) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    <div class="absolute top-1 left-1 bg-black/40 text-white text-[10px] px-1 py-0.5 rounded">⬆ Atas</div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs text-red-300 py-4">Belum ada gambar di posisi ini.</div>
            @endforelse
        </div>
    </div>

    {{-- ── Gambar Di Bawah ─────────────────────────────── --}}
    @php $sectionsBelow = $sections->where('position', 'below'); @endphp
    <div>
        <div class="flex items-center gap-2 mb-2">
            <span class="text-xs font-bold text-white bg-gray-500 px-2 py-0.5 rounded">⬇ Di Bawah Daftar Anggota</span>
            <span class="text-xs text-gray-400">{{ $sectionsBelow->count() }} gambar</span>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 min-h-[80px] bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-2" id="sortable-sections-below">
            @forelse($sectionsBelow as $sec)
                <div data-id="{{ $sec->id }}" class="relative group rounded-lg overflow-hidden border shadow-sm cursor-move bg-white">
                    <img src="{{ asset('storage/' . $sec->image) }}" class="w-full h-28 object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                        <form action="{{ route('admin.members.sections.destroy', $sec->id) }}" method="POST" onsubmit="return confirm('Hapus gambar ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    <div class="absolute top-1 left-1 bg-black/40 text-white text-[10px] px-1 py-0.5 rounded">⬇ Bawah</div>
                </div>
            @empty
                <div class="col-span-full text-center text-xs text-gray-300 py-4">Belum ada gambar di posisi ini.</div>
            @endforelse
        </div>
    </div>
</div>

<hr class="mb-8 border-gray-200">

{{-- ═══════════════════════════════════════════════ --}}
{{-- PANEL 2: DAFTAR ANGGOTA                         --}}
{{-- ═══════════════════════════════════════════════ --}}
<div class="flex justify-between items-center mb-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Anggota</h2>
        <p class="text-gray-500 text-sm mt-1">Seret baris untuk mengubah urutan tampil di halaman publik.</p>
    </div>
    <a href="{{ route('admin.members.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
        + Tambah Anggota
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-8"></th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Foto</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                <th class="px-4 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jabatan</th>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = '{{ csrf_token() }}';

    function makeGridSortable(elId, reorderUrl) {
        var el = document.getElementById(elId);
        if (!el) return;
        Sortable.create(el, {
            animation: 150,
            ghostClass: 'opacity-40',
            filter: '.col-span-full', // skip empty placeholders
            onEnd: function () {
                var items = [];
                el.querySelectorAll('div[data-id]').forEach(function (div, index) {
                    items.push({ id: div.getAttribute('data-id'), order: index + 1 });
                });
                if (items.length === 0) return;
                fetch(reorderUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ orders: items })
                });
            }
        });
    }

    makeGridSortable('sortable-sections-above', '{{ route("admin.members.sections.reorder") }}');
    makeGridSortable('sortable-sections-below', '{{ route("admin.members.sections.reorder") }}');

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
