@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h1>
        <p class="text-gray-600">Punya pertanyaan, masukan, atau ingin mengajak kerjasama? Jangan ragu untuk mengirimkan pesan melalui form di bawah ini.</p>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
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
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subjek</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                       class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('subject') border-red-500 @enderror">
                @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan Anda</label>
                <textarea name="message" id="message" rows="5" required
                          class="w-full rounded-md border-gray-300 shadow-sm border px-4 py-2 focus:border-blue-500 focus:ring-blue-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
