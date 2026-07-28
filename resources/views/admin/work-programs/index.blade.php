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
                <td class="px-3 py-5 border-b border-gray-200 text-center text-gray-400 font-bold drag-handle cursor-move select-none" title="Tarik untuk mengubah urutan">
                    <span class="text-base text-gray-400 hover:text-red-600 font-extrabold px-2 py-1 bg-gray-100 rounded">⋮⋮</span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-16 h-12 rounded object-cover shadow-sm">
                    @else
                        <div class="w-16 h-12 rounded bg-gray-200 flex items-center justify-center text-gray-500 text-xs shadow-sm">No Image</div>
                    @endif
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $item->title }}</p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <p class="text-gray-900 whitespace-no-wrap">
                        @if($item->schedule)
                            <span class="font-semibold text-red-700 bg-red-50 px-2.5 py-1 rounded border border-red-100 text-xs inline-block">{{ $item->schedule }}</span>
                            @if($item->start_date || $item->end_date)
                                <br><span class="text-xs text-gray-500 mt-1 inline-block">{{ $item->start_date ? $item->start_date->format('d M Y') : '' }} {{ $item->end_date ? 's/d ' . $item->end_date->format('d M Y') : '' }}</span>
                            @endif
                        @elseif($item->start_date && $item->end_date)
                            {{ $item->start_date->format('d M Y') }} <br> 
                            <span class="text-gray-500 text-xs">s/d</span> <br> 
                            {{ $item->end_date->format('d M Y') }}
                        @elseif($item->start_date)
                            {{ $item->start_date->format('d M Y') }} <br>
                            <span class="text-gray-500 text-xs">(Mulai)</span>
                        @elseif($item->end_date)
                            {{ $item->end_date->format('d M Y') }} <br>
                            <span class="text-gray-500 text-xs">(Selesai)</span>
                        @else
                            <span class="text-gray-400 italic">Opsional</span>
                        @endif
                    </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        @if($item->status === 'completed') text-green-900 
                        @elseif($item->status === 'ongoing') text-red-900 
                        @else text-gray-900 @endif">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            @if($item->status === 'completed') bg-green-200 
                            @elseif($item->status === 'ongoing') bg-red-200 
                            @else bg-gray-200 @endif"></span>
                        <span class="relative capitalize">
                            @if($item->status === 'completed') Selesai
                            @elseif($item->status === 'ongoing') Sedang Berjalan
                            @else Direncanakan @endif
                        </span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <div class="flex items-center gap-3 flex-wrap">
                        <a href="{{ route('admin.work-programs.detail', $item->id) }}"
                           class="text-purple-600 hover:text-purple-900 font-semibold">Kelola Detail</a>
                        <a href="{{ route('admin.work-programs.edit', $item->id) }}"
                           class="text-red-600 hover:text-red-900 font-semibold">Edit</a>
                        <form action="{{ route('admin.work-programs.destroy', $item->id) }}" method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kerja ini?');">
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
