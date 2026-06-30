@extends('layouts.app')

@section('title', 'Kontak Kami')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
        <p class="text-gray-600">Punya pertanyaan, masukan, atau ingin mengajak kerjasama? Jangan ragu untuk mengirimkan pesan melalui form di bawah ini.</p>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
        <!-- Arahkan ke route pemrosesan kontak Anda -->
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Honeypot untuk menangkal bot -->
            <div style="display:none;">
                <label for="website_url">Website URL</label>
                <input type="text" name="website_url" id="website_url" autocomplete="off" tabindex="-1">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Field Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Pengirim <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-3 focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama Anda">
                    @error('name')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Field Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-3 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Field Subjek -->
            <div>
                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-3 focus:border-blue-500 focus:ring-blue-500 @error('subject') border-red-500 @enderror"
                       placeholder="Perihal pesan">
                @error('subject')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Field Pesan -->
            <div>
                <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Pesan Anda <span class="text-red-500">*</span></label>
                <textarea name="message" id="message" rows="5" required
                          class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-3 focus:border-blue-500 focus:ring-blue-500 @error('message') border-red-500 @enderror"
                          placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                @error('message')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="pt-2">
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-base font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    Kirim Pesan Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
