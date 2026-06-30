@extends('layouts.admin')

@section('page_title', 'Kelola Program Kerja')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">Daftar Program Kerja</h2>
    <a href="{{ route('admin.work-programs.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
        + Tambah Program Kerja
    </a>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full leading-normal">
        <thead>
            <tr>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Judul</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($workPrograms as $item)
            <tr class="hover:bg-gray-50">
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
                        {{ $item->start_date ? $item->start_date->format('d M Y') : '-' }} <br> 
                        <span class="text-gray-500 text-xs">s/d</span> <br> 
                        {{ $item->end_date ? $item->end_date->format('d M Y') : '-' }}
                    </p>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm">
                    <span class="relative inline-block px-3 py-1 font-semibold leading-tight 
                        @if($item->status === 'completed') text-green-900 
                        @elseif($item->status === 'ongoing') text-blue-900 
                        @else text-gray-900 @endif">
                        <span aria-hidden class="absolute inset-0 opacity-50 rounded-full 
                            @if($item->status === 'completed') bg-green-200 
                            @elseif($item->status === 'ongoing') bg-blue-200 
                            @else bg-gray-200 @endif"></span>
                        <span class="relative capitalize">
                            @if($item->status === 'completed') Selesai
                            @elseif($item->status === 'ongoing') Sedang Berjalan
                            @else Direncanakan @endif
                        </span>
                    </span>
                </td>
                <td class="px-5 py-5 border-b border-gray-200 text-sm flex items-center space-x-4 mt-2">
                    <a href="{{ route('admin.work-programs.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Edit</a>
                    <form action="{{ route('admin.work-programs.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program kerja ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 border-b border-gray-200 text-sm text-center text-gray-500">
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
@endsection
