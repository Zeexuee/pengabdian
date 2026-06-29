@extends('layouts.admin')

@section('page_title', 'Tinjau Permintaan Gabung')

@section('content')
<div class="max-w-4xl bg-white p-8 rounded-lg shadow-sm border border-gray-100">
    
    <!-- Header / Profil Pendaftar -->
    <div class="flex justify-between items-start mb-6 border-b pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Aplikasi Pendaftaran: {{ $joinRequest->name }}</h2>
            <div class="text-sm text-gray-600 space-y-1">
                <p>Email: <strong class="text-gray-800">{{ $joinRequest->email }}</strong></p>
                <p>Telepon/WA: <strong class="text-gray-800">{{ $joinRequest->phone_number ?? 'Tidak dicantumkan' }}</strong></p>
                <p>Tanggal Pengajuan: <span class="text-gray-800">{{ $joinRequest->created_at->format('d M Y, H:i') }}</span></p>
            </div>
        </div>
        
        <!-- Status Saat Ini -->
        <div class="text-right">
            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Saat Ini</span>
            @if($joinRequest->status === 'approved')
                <span class="px-4 py-2 bg-green-100 text-green-800 font-bold rounded-full text-sm">Diterima (Approved)</span>
            @elseif($joinRequest->status === 'rejected')
                <span class="px-4 py-2 bg-red-100 text-red-800 font-bold rounded-full text-sm">Ditolak (Rejected)</span>
            @else
                <span class="px-4 py-2 bg-yellow-100 text-yellow-800 font-bold rounded-full text-sm">Menunggu (Pending)</span>
            @endif
        </div>
    </div>

    <!-- Alasan Bergabung -->
    <div class="mb-10">
        <h3 class="text-lg font-bold text-gray-800 mb-3">Motivasi & Alasan Bergabung</h3>
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 text-gray-800 whitespace-pre-wrap leading-relaxed">
            {{ $joinRequest->reason ?? 'Tidak ada alasan yang dituliskan.' }}
        </div>
    </div>

    <!-- Form Aksi Keputusan Admin -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
        <h3 class="text-md font-bold text-blue-900 mb-2">Ambil Keputusan</h3>
        <p class="text-sm text-blue-800 mb-4">Ubah status pendaftaran ini sesuai dengan hasil evaluasi komite/admin.</p>
        
        <form action="{{ route('admin.join_requests.update_status', $joinRequest->id) }}" method="POST" class="flex flex-col sm:flex-row items-end gap-4">
            @csrf
            @method('PUT')
            
            <div class="flex-grow w-full sm:w-auto">
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Ubah Status Menjadi:</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3">
                    <option value="pending" {{ $joinRequest->status == 'pending' ? 'selected' : '' }}>Biarkan Pending</option>
                    <option value="approved" {{ $joinRequest->status == 'approved' ? 'selected' : '' }}>Terima (Approved)</option>
                    <option value="rejected" {{ $joinRequest->status == 'rejected' ? 'selected' : '' }}>Tolak (Rejected)</option>
                </select>
            </div>
            
            <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition shadow-sm">
                Simpan Keputusan
            </button>
        </form>
    </div>

    <!-- Navigasi Bawah -->
    <div class="border-t pt-6 flex justify-between items-center">
        <a href="{{ route('admin.join_requests.index') }}" class="text-gray-600 hover:text-gray-900 font-medium inline-flex items-center">
            &larr; Kembali ke Daftar
        </a>
        
        <form action="{{ route('admin.join_requests.destroy', $joinRequest->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini secara permanen? Data tidak dapat dikembalikan.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 font-medium bg-red-50 hover:bg-red-100 px-4 py-2 rounded transition">
                Hapus Data
            </button>
        </form>
    </div>
</div>
@endsection
