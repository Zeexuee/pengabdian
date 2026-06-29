@extends('layouts.admin')

@section('page_title', 'Detail Pesan Kontak')

@section('content')
<div class="max-w-4xl bg-white p-8 rounded-lg shadow-sm border border-gray-100">
    
    <div class="flex justify-between items-start mb-6 border-b pb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $contact->subject }}</h2>
            <div class="flex items-center text-sm text-gray-500 space-x-4">
                <span>Dari: <strong class="text-gray-700">{{ $contact->name }}</strong> ({{ $contact->email }})</span>
                <span>Tgl: {{ $contact->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
        
        <!-- Form Ubah Status Cepat -->
        <form action="{{ route('admin.contacts.update_status', $contact->id) }}" method="POST" class="flex items-center space-x-2 bg-gray-50 p-2 rounded-md border">
            @csrf
            @method('PUT')
            <label for="is_read" class="text-xs font-semibold text-gray-600">Status:</label>
            <select name="is_read" id="is_read" class="text-sm border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 p-1">
                <option value="0" {{ !$contact->is_read ? 'selected' : '' }}>Belum Dibaca</option>
                <option value="1" {{ $contact->is_read ? 'selected' : '' }}>Sudah Dibaca</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded">
                Simpan
            </button>
        </form>
    </div>

    <div class="prose max-w-none text-gray-800 whitespace-pre-wrap leading-relaxed mb-10">
        {{ $contact->message }}
    </div>

    <div class="border-t pt-6 flex justify-between items-center">
        <a href="{{ route('admin.contacts.index') }}" class="text-gray-600 hover:text-gray-900 font-medium inline-flex items-center">
            &larr; Kembali ke Daftar Pesan
        </a>
        
        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini secara permanen?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 hover:text-red-800 font-medium bg-red-50 hover:bg-red-100 px-4 py-2 rounded transition">
                Hapus Pesan
            </button>
        </form>
    </div>
</div>
@endsection
