@extends('layouts.admin')

@section('page_title', 'Detail Permintaan Gabung')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.join_requests.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">Profil Calon Anggota</h3>
    
    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-sm text-gray-500">Nama Lengkap</p>
            <p class="font-semibold text-gray-800">{{ $join_request->name }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-semibold text-gray-800"><a href="mailto:{{ $join_request->email }}" class="text-blue-600">{{ $join_request->email }}</a></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Nomor Telepon</p>
            <p class="font-semibold text-gray-800">{{ $join_request->phone_number }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Tanggal Daftar</p>
            <p class="font-semibold text-gray-800">{{ $join_request->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Status Saat Ini</p>
            <p class="font-semibold text-gray-800 capitalize
                @if($join_request->status === 'approved') text-green-600 
                @elseif($join_request->status === 'rejected') text-red-600 
                @else text-orange-600 @endif
            ">
                {{ $join_request->status }}
            </p>
        </div>
    </div>

    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-2">Alasan Bergabung / Portofolio:</p>
        <div class="p-4 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-line border border-gray-200">
            {{ $join_request->reason }}
        </div>
    </div>

    <div class="border-t pt-4">
        <h4 class="text-lg font-bold text-gray-800 mb-3">Tindakan Admin</h4>
        <form action="{{ route('admin.join_requests.update_status', $join_request->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Ubah Status:</label>
                <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="pending" {{ $join_request->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $join_request->status === 'approved' ? 'selected' : '' }}>Approved (Terima)</option>
                    <option value="rejected" {{ $join_request->status === 'rejected' ? 'selected' : '' }}>Rejected (Tolak)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (Opsional):</label>
                <textarea name="admin_notes" id="admin_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Tambahkan catatan mengapa diterima/ditolak...">{{ old('admin_notes', $join_request->admin_notes) }}</textarea>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
