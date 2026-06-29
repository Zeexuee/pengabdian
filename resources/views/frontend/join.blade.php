@extends('layouts.app')

@section('title', 'Gabung Komunitas')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Bergabung Bersama Kami</h1>
        <p class="text-gray-600">Isi formulir pendaftaran di bawah ini untuk menjadi bagian dari perjalanan komunitas kami. Admin akan me-review permintaan Anda segera.</p>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('join.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon/WhatsApp (Opsional)</label>
                <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                       class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('phone_number') border-red-500 @enderror">
                @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan Bergabung</label>
                <textarea name="reason" id="reason" rows="4" required placeholder="Ceritakan motivasi Anda bergabung dengan komunitas ini..."
                          class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('reason') border-red-500 @enderror">{{ old('reason') }}</textarea>
                @error('reason')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Kirim Permintaan Bergabung
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
