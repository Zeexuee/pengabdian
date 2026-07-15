@extends('layouts.admin')

@section('page_title', 'Pengaturan Beranda (Page Builder)')

@section('content')
<div class="mb-10">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Banner Hero Utama</h2>
            <p class="text-gray-600 text-sm mt-1">Tambahkan beberapa gambar untuk membuat slider otomatis di bagian teratas halaman utama.</p>
        </div>
        <!-- Tombol upload via form di bawah -->
    </div>

    <!-- Form Upload Hero -->
    <div class="bg-white p-4 rounded-lg shadow-sm border mb-4">
        <form action="{{ route('admin.home-sections.hero.store') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-4">
            @csrf
            <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded font-bold hover:bg-blue-700 transition flex-shrink-0">
                Upload Gambar
            </button>
        </form>
    </div>

    <!-- Daftar Hero -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="sortable-hero">
        @forelse($heroes as $hero)
            <div data-id="{{ $hero->id }}" class="relative group rounded-lg overflow-hidden border shadow-sm cursor-move">
                <img src="{{ asset('storage/' . $hero->image) }}" class="w-full h-32 object-cover">
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <form action="{{ route('admin.home-sections.hero.destroy', $hero->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-red-600 text-white rounded-full hover:bg-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-4 p-8 text-center bg-gray-50 rounded-lg border border-dashed border-gray-300 text-gray-500">
                Belum ada gambar Banner Hero.
            </div>
        @endforelse
    </div>
</div>

<hr class="mb-10 border-gray-300">

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Komponen Lainnya</h2>
        <p class="text-gray-600 text-sm mt-1">Komponen yang akan tampil di bawah Hero Banner.</p>
    </div>
    <a href="{{ route('admin.home-sections.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        + Tambah Komponen
    </a>
</div>

<div class="bg-white border rounded-lg overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50 border-b">
                <th class="py-3 px-4 w-12"></th> <!-- Untuk handle drag -->
                <th class="py-3 px-4 font-semibold text-sm text-gray-700">Tipe</th>
                <th class="py-3 px-4 font-semibold text-sm text-gray-700">Pratinjau / Judul</th>
                <th class="py-3 px-4 font-semibold text-sm text-gray-700">Status</th>
                <th class="py-3 px-4 font-semibold text-sm text-gray-700 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-list">
            @forelse($sections as $item)
                <tr data-id="{{ $item->id }}" class="border-b hover:bg-gray-50 transition cursor-move">
                    <td class="py-3 px-4 text-gray-400">
                        <!-- Drag handle icon -->
                        <svg class="w-5 h-5 cursor-grab" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path></svg>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-bold uppercase tracking-wider">
                            {{ str_replace('_', ' ', $item->type) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        @if($item->title)
                            <div class="font-semibold text-gray-800">{{ $item->title }}</div>
                        @endif
                        @if($item->type == 'text' && !$item->title)
                            <div class="text-sm text-gray-500 italic">Teks Paragraf...</div>
                        @endif
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="h-10 object-cover mt-1 rounded border" alt="preview">
                        @endif
                    </td>
                    <td class="py-3 px-4">
                        @if($item->is_active)
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Aktif</span>
                        @else
                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Nonaktif</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 flex items-center space-x-3">
                        <a href="{{ route('admin.home-sections.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 transition">Edit</a>
                        <form action="{{ route('admin.home-sections.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus komponen ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        Belum ada komponen yang ditambahkan. Halaman utama mungkin terlihat kosong.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var el = document.getElementById('sortable-list');
        if (el) {
            var sortable = Sortable.create(el, {
                animation: 150,
                ghostClass: 'bg-blue-50',
                onEnd: function (evt) {
                    var items = [];
                    el.querySelectorAll('tr').forEach(function(row, index) {
                        items.push({
                            id: row.getAttribute('data-id'),
                            order: index + 1
                        });
                    });

                    // Kirim ke server
                    fetch('{{ route("admin.home-sections.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orders: items })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // Optional: Tampilkan toast / notif kecil
                            console.log('Urutan berhasil diperbarui.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui urutan.');
                    });
                }
            });
        }
        var elHero = document.getElementById('sortable-hero');
        if (elHero) {
            var sortableHero = Sortable.create(elHero, {
                animation: 150,
                ghostClass: 'bg-blue-50',
                onEnd: function (evt) {
                    var items = [];
                    elHero.querySelectorAll('div[data-id]').forEach(function(row, index) {
                        items.push({
                            id: row.getAttribute('data-id'),
                            order: index + 1
                        });
                    });

                    fetch('{{ route("admin.home-sections.hero.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ orders: items })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            console.log('Urutan hero berhasil diperbarui.');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        alert('Gagal memperbarui urutan hero.');
                    });
                }
            });
        }
    });
</script>
@endpush
