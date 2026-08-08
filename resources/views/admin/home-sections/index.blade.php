@extends('layouts.admin')

@section('page_title', 'Pengaturan Beranda (Page Builder)')

@section('content')

<!-- Toast Notification Container -->
<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col space-y-2 pointer-events-none"></div>

<!-- HERO BANNER SLIDER MANAGEMENT -->
<div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
    <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Slider Banner Hero (Header Beranda)
            </h2>
            <p class="text-gray-600 text-sm mt-1">Upload dan susun gambar yang tampil di slider bagian teratas halaman utama.</p>
        </div>
    </div>

    <!-- Form Upload Hero -->
    <form action="{{ route('admin.home-sections.hero.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap sm:flex-nowrap items-center gap-4 mb-6 p-4 bg-slate-50 rounded-lg border border-slate-200">
        @csrf
        <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" required>
        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 transition shadow-sm flex-shrink-0 text-sm">
            + Upload Gambar Hero
        </button>
    </form>

    <!-- Daftar Hero -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="sortable-hero">
        @forelse($heroes as $hero)
            <div data-id="{{ $hero->id }}" class="relative group rounded-xl overflow-hidden border shadow-sm cursor-move bg-slate-900">
                <img src="{{ asset('storage/' . $hero->image) }}" class="w-full h-36 object-contain">
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center space-x-2">
                    <form action="{{ route('admin.home-sections.hero.destroy', $hero->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus gambar hero ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2.5 bg-red-600 text-white rounded-full hover:bg-red-700 transition shadow" title="Hapus Gambar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
                <div class="absolute top-2 left-2 bg-black/70 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow backdrop-blur-sm">
                    Tarik untuk geser
                </div>
            </div>
        @empty
            <div class="col-span-4 p-8 text-center bg-gray-50 rounded-xl border border-dashed border-gray-300 text-gray-500 text-sm">
                Belum ada gambar Slider Hero. Upload beberapa gambar di atas.
            </div>
        @endforelse
    </div>
</div>

<hr class="mb-10 border-gray-200">

<!-- DRAG AND SWAP ALL HOME COMPONENTS -->
<div class="mb-6 flex flex-wrap justify-between items-center gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            Susunan Komponen Beranda (Drag & Swap)
        </h2>
        <p class="text-gray-600 text-sm mt-1">
            Gunakan ikon <strong class="text-red-600">⋮⋮ (Drag & Swap)</strong> atau tombol panah <strong class="text-red-600">▲ ▼</strong> untuk mengubah urutan tampilan komponen pada halaman utama secara bebas.
        </p>
    </div>
    <a href="{{ route('admin.home-sections.create') }}" class="px-5 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition shadow-sm text-sm">
        + Tambah Komponen Baru
    </a>
</div>

<div class="bg-white border rounded-xl overflow-hidden shadow-sm mb-12">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-gray-200">
                    <th class="py-3.5 px-4 w-20 text-center font-semibold text-xs text-gray-600 uppercase tracking-wider">Urutan</th>
                    <th class="py-3.5 px-4 font-semibold text-xs text-gray-600 uppercase tracking-wider">Tipe Komponen</th>
                    <th class="py-3.5 px-4 font-semibold text-xs text-gray-600 uppercase tracking-wider">Judul / Detail Ringkas</th>
                    <th class="py-3.5 px-4 font-semibold text-xs text-gray-600 uppercase tracking-wider text-center">Status Tampil</th>
                    <th class="py-3.5 px-4 font-semibold text-xs text-gray-600 uppercase tracking-wider text-right w-44">Aksi</th>
                </tr>
            </thead>
            <tbody id="sortable-list" class="divide-y divide-gray-100">
                @forelse($sections as $item)
                    <tr data-id="{{ $item->id }}" class="hover:bg-slate-50/80 transition cursor-move group">
                        <!-- Drag Handle & Swap Buttons -->
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center space-x-1">
                                <span class="drag-handle p-1.5 rounded hover:bg-gray-200 text-gray-400 group-hover:text-red-600 cursor-grab select-none font-bold text-lg" title="Tarik & Lepas untuk mengubah urutan">
                                    ⋮⋮
                                </span>
                                <div class="flex flex-col space-y-0.5">
                                    <button type="button" class="btn-swap-up p-0.5 text-gray-400 hover:text-red-600 rounded hover:bg-gray-100 text-xs font-bold leading-none" title="Naikkan urutan">▲</button>
                                    <button type="button" class="btn-swap-down p-0.5 text-gray-400 hover:text-red-600 rounded hover:bg-gray-100 text-xs font-bold leading-none" title="Turunkan urutan">▼</button>
                                </div>
                            </div>
                        </td>

                        <!-- Tipe Badge -->
                        <td class="py-3.5 px-4 whitespace-nowrap">
                            @if(str_starts_with($item->type, 'system_') || $item->type === 'hero')
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-200 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ str_replace(['system_', '_'], ['', ' '], $item->type) }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 rounded-md text-xs font-bold uppercase tracking-wider inline-flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    {{ str_replace('_', ' ', $item->type) }}
                                </span>
                            @endif
                        </td>

                        <!-- Judul / Preview -->
                        <td class="py-3.5 px-4 max-w-xs sm:max-w-md">
                            <div class="font-semibold text-gray-900 text-sm line-clamp-2 break-words" title="{{ $item->title }}">
                                {{ Str::limit($item->title ?? 'Tanpa Judul', 80) }}
                            </div>
                            @if($item->content)
                                <div class="text-xs text-gray-500 line-clamp-2 mt-0.5 break-words">
                                    {{ Str::limit(strip_tags($item->content), 120) }}
                                </div>
                            @endif
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="h-10 object-cover mt-1.5 rounded border border-gray-200 shadow-sm" alt="preview">
                            @endif
                        </td>

                        <!-- Status Active Toggle Switch -->
                        <td class="py-3.5 px-4 text-center whitespace-nowrap">
                            <button type="button" onclick="toggleSectionStatus({{ $item->id }}, this)"
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border transition shadow-sm {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200' }}">
                                <span class="w-2 h-2 rounded-full mr-1.5 {{ $item->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                <span class="status-label">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.home-sections.edit', $item->id) }}" class="inline-flex items-center text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-2.5 py-1.5 rounded transition shadow-sm">
                                    <svg class="w-3.5 h-3.5 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                @if(!str_starts_with($item->type, 'system_') && $item->type !== 'hero')
                                    <form action="{{ route('admin.home-sections.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komponen ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-2.5 py-1.5 rounded transition shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                @else
                                    <span class="inline-flex items-center text-xs text-gray-400 bg-gray-100 border border-gray-200 px-2 py-1 rounded cursor-not-allowed" title="Komponen sistem tidak dapat dihapus">
                                        Sistem
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 text-sm">
                            Belum ada komponen yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `pointer-events-auto flex items-center px-4 py-3 rounded-lg shadow-lg text-sm font-medium text-white transition-all transform duration-300 translate-y-2 opacity-0 ${type === 'success' ? 'bg-emerald-600' : 'bg-red-600'}`;
        toast.innerHTML = `<span>${type === 'success' ? '✓' : '✕'}</span><span class="ml-2">${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.classList.remove('translate-y-2', 'opacity-0');
        }, 10);

        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function saveNewOrder() {
        const el = document.getElementById('sortable-list');
        const items = [];
        el.querySelectorAll('tr[data-id]').forEach(function(row, index) {
            items.push({
                id: row.getAttribute('data-id'),
                order: index + 1
            });
        });

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
                showToast('Urutan komponen berhasil diperbarui!');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            showToast('Gagal memperbarui urutan komponen.', 'error');
        });
    }

    function toggleSectionStatus(id, btn) {
        fetch(`{{ url('admin/home-sections') }}/${id}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.json())
        .then(data => {
            if(data.success) {
                const label = btn.querySelector('.status-label');
                const dot = btn.querySelector('span');

                if(data.is_active) {
                    btn.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border transition shadow-sm bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100";
                    dot.className = "w-2 h-2 rounded-full mr-1.5 bg-emerald-500";
                    label.innerText = 'Aktif';
                } else {
                    btn.className = "inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border transition shadow-sm bg-gray-100 text-gray-600 border-gray-300 hover:bg-gray-200";
                    dot.className = "w-2 h-2 rounded-full mr-1.5 bg-gray-400";
                    label.innerText = 'Nonaktif';
                }
                showToast(data.message);
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Gagal mengubah status komponen.', 'error');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const el = document.getElementById('sortable-list');
        if (el) {
            Sortable.create(el, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'bg-red-50',
                onEnd: function () {
                    saveNewOrder();
                }
            });

            // Click up/down arrow buttons to swap rows
            el.addEventListener('click', function(e) {
                const upBtn = e.target.closest('.btn-swap-up');
                const downBtn = e.target.closest('.btn-swap-down');
                
                if (upBtn) {
                    const row = upBtn.closest('tr');
                    const prev = row.previousElementSibling;
                    if (prev && prev.matches('tr[data-id]')) {
                        row.parentNode.insertBefore(row, prev);
                        saveNewOrder();
                    }
                } else if (downBtn) {
                    const row = downBtn.closest('tr');
                    const next = row.nextElementSibling;
                    if (next && next.matches('tr[data-id]')) {
                        row.parentNode.insertBefore(next, row);
                        saveNewOrder();
                    }
                }
            });
        }

        const elHero = document.getElementById('sortable-hero');
        if (elHero) {
            Sortable.create(elHero, {
                animation: 150,
                ghostClass: 'bg-red-50',
                onEnd: function () {
                    const items = [];
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
                            showToast('Urutan slider hero berhasil diperbarui!');
                        }
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        showToast('Gagal memperbarui urutan hero.', 'error');
                    });
                }
            });
        }
    });
</script>
@endpush
