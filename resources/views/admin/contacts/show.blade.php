@extends('layouts.admin')

@section('page_title', 'Detail Pesan Kontak')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Daftar Pesan</a>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $contact->subject }}</h3>
    
    <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <p class="text-sm text-gray-500">Pengirim</p>
            <p class="font-semibold text-gray-800">{{ $contact->name }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Email</p>
            <p class="font-semibold text-gray-800"><a href="mailto:{{ $contact->email }}" class="text-blue-600">{{ $contact->email }}</a></p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Tanggal Dikirim</p>
            <p class="font-semibold text-gray-800">{{ $contact->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Status</p>
            <p class="font-semibold text-gray-800">
                @if($contact->is_read)
                    <span class="text-green-600">Sudah Dibaca</span>
                @else
                    <span class="text-orange-600">Belum Dibaca</span>
                @endif
            </p>
        </div>
    </div>

    <div class="mb-6">
        <p class="text-sm text-gray-500 mb-2">Pesan:</p>
        <div class="p-4 bg-gray-50 rounded-lg text-gray-800 whitespace-pre-line border border-gray-200">
            {{ $contact->message }}
        </div>
    </div>

    <div class="border-t pt-4">
        <form action="{{ route('admin.contacts.update_status', $contact->id) }}" method="POST" class="flex items-center space-x-4">
            @csrf
            @method('PUT')
            <label for="is_read" class="text-sm font-medium text-gray-700">Ubah Status:</label>
            <select name="is_read" id="is_read" class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                <option value="1" {{ $contact->is_read ? 'selected' : '' }}>Sudah Dibaca</option>
                <option value="0" {{ !$contact->is_read ? 'selected' : '' }}>Belum Dibaca</option>
            </select>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition text-sm">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection
