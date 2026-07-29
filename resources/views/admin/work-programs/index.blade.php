@extends('layouts.admin')

@section('page_title', 'Kelola Program Kerja')

@section('content')
<div class="flex flex-wrap justify-between items-center mb-6 gap-3">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Daftar Program Kerja</h2>
        <p class="text-sm text-gray-500 mt-1">Gunakan ikon <strong>⋮⋮ (Drag)</strong> di sebelah kiri untuk mengubah urutan tampilan card program kerja secara bebas.</p>
    </div>
    <a href="{{ route('admin.work-programs.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
        + Tambah Program Kerja
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="w-10 px-3 py-3 border-b-2 border-gray-200 bg-gray-50 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Urutan</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal / Jadwal</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody id="sortable-work-programs">
            @forelse($workPrograms as $item)
            <tr data-id="{{ $item->id }}" class="hover:bg-gray-50 transition-colors">
                <td class="px-3 py-4 border-b border-gray-200 text-center text-gray-400 font-bold drag-handle cursor-move select-none" title="Tarik untuk mengubah urutan">
                    <span class="text-base text-gray-400 hover:text-red-600 font-extrabold px-2 py-1 bg-gray-100 rounded">⋮⋮</span>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-16 h-12 rounded object-cover shadow-sm">
                    @else
                        <div class="w-16 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-xs shadow-sm">No Image</div>
                    @endif
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 font-semibold max-w-xs">{{ $item->title }}</p>
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm whitespace-nowrap">
                    @if($item->schedule)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200 mb-1">
                            {{ $item->schedule }}
                        </span>
                        @if($item->start_date || $item->end_date)
                            <div class="text-xs text-gray-500 mt-0.5">
                                @if($item->start_date && $item->end_date)
                                    {{ $item->start_date->format('d M Y') }}
                                    @if(!$item->start_date->isSameDay($item->end_date))
                                        s/d {{ $item->end_date->format('d M Y') }}
                                    @endif
                                @elseif($item->start_date)
                                    {{ $item->start_date->format('d M Y') }} (Mulai)
                                @elseif($item->end_date)
                                    {{ $item->end_date->format('d M Y') }} (Selesai)
                                @endif
                            </div>
                        @endif
                    @elseif($item->start_date && $item->end_date)
                        <div class="text-sm text-gray-900 font-medium">
                            @if($item->start_date->isSameDay($item->end_date))
                                {{ $item->start_date->format('d M Y') }}
                            @else
                                {{ $item->start_date->format('d M Y') }} <span class="text-xs text-gray-400 font-normal">s/d</span> {{ $item->end_date->format('d M Y') }}
                            @endif
                        </div>
                    @elseif($item->start_date)
                        <div class="text-sm text-gray-900 font-medium">
                            {{ $item->start_date->format('d M Y') }} <span class="text-xs text-gray-400 font-normal">(Mulai)</span>
                        </div>
                    @elseif($item->end_date)
                        <div class="text-sm text-gray-900 font-medium">
                            {{ $item->end_date->format('d M Y') }} <span class="text-xs text-gray-400 font-normal">(Selesai)</span>
                        </div>
                    @else
                        <span class="text-gray-400 text-xs italic">Opsional</span>
                    @endif
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm whitespace-nowrap">
                    @if($item->status === 'completed')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                            Selesai
                        </span>
                    @elseif($item->status === 'ongoing')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                            Sedang Berjalan
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                            Direncanakan
                        </span>
                    @endif
                </td>
                <td class="px-5 py-4 border-b border-gray-200 text-sm whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.work-programs.detail', $item->id) }}"
                           class="inline-flex items-center text-xs font-semibold text-purple-700 bg-purple-50 hover:bg-purple-100 border border-purple-200 px-2.5 py-1.5 rounded transition shadow-sm">
                            Kelola Detail
                        </a>
                        <a href="{{ route('admin.work-programs.edit', $item->id) }}"
                           class="inline-flex items-center text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-2.5 py-1.5 rounded transition shadow-sm">
                            Edit
                        </a>
                        <form action="{{ route('admin.work-programs.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kerja ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 px-2.5 py-1.5 rounded transition shadow-sm">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
                    Belum ada data program kerja.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if(isset($workPrograms) && $workPrograms->hasPages())
<div class="mt-4">
    {{ $workPrograms->links() }}
</div>
@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById('sortable-work-programs');
    if (!el) return;

    Sortable.create(el, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'bg-red-50',
        onEnd: function () {
            const items = [];
            el.querySelectorAll('tr[data-id]').forEach(function (row, index) {
                items.push({ id: row.getAttribute('data-id'), order: index + 1 });
            });

            if (items.length === 0) return;

            fetch('{{ url("admin/work-programs/reorder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ orders: items })
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    el.style.transition = 'opacity 0.2s';
                    el.style.opacity = '0.5';
                    setTimeout(() => el.style.opacity = '1', 300);
                }
            });
        }
    });
});
</script>
@endpush
@endsection
