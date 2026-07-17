@extends('layouts.admin')

@section('page_title', 'Edit Produk')

@section('content')

{{-- ===== SECTION HAPUS GAMBAR (di luar form utama) ===== --}}
@if($product->images->count() > 0)
<div class="max-w-4xl mb-6 bg-white border border-gray-200 rounded-lg p-4">
    <label class="block text-gray-700 font-semibold mb-3">Gambar Saat Ini</label>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        @foreach($product->images as $img)
        <div class="relative group" id="img-wrap-{{ $img->id }}">
            <img src="{{ asset($img->image) }}"
                 alt="Gambar produk"
                 class="w-full h-28 object-contain rounded-lg border border-gray-200 bg-gray-50">
            <button type="button"
                    onclick="deleteImage({{ $img->id }}, '{{ route('admin.products.images.destroy', [$product->id, $img->id]) }}')"
                    class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700"
                    title="Hapus gambar">
                &times;
            </button>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ===== FORM UTAMA (tidak ada form lain di dalamnya) ===== --}}
<div class="max-w-4xl">
    <form id="edit-product-form" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Nama Produk --}}
        <div>
            <label for="name" class="block text-gray-700 font-semibold mb-2">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                   class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 @error('name') border-red-500 @enderror"
                   placeholder="Contoh: Pot Bunga Daur Ulang">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Kategori & Harga --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="category" class="block text-gray-700 font-semibold mb-2">Kategori <span class="text-gray-400 font-normal text-sm">(opsional)</span></label>
                <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}"
                       class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="Contoh: Kertas, Plastik, Organik">
            </div>
            <div>
                <label for="price" class="block text-gray-700 font-semibold mb-2">Harga <span class="text-gray-400 font-normal text-sm">(opsional)</span></label>
                <input type="text" name="price" id="price" value="{{ old('price', $product->price) }}"
                       class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                       placeholder="Contoh: Rp 15.000/buah">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="description_editor" class="block text-gray-700 font-semibold mb-2">Deskripsi Produk</label>
            <textarea name="description" id="description_editor" rows="6"
                      class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Ganti Gambar --}}
        <div>
            <label class="block text-gray-700 font-semibold mb-2">
                Ganti Semua Gambar
                <span class="text-gray-400 font-normal text-sm">(opsional — jika diisi, gambar lama akan diganti)</span>
            </label>

            {{-- Input tersembunyi — dikelola JS --}}
            <input type="file" id="images-picker" accept="image/*" multiple style="display:none;">
            <input type="file" name="images[]" id="images-real-input" accept="image/*" multiple style="display:none;">

            {{-- Tombol tambah --}}
            <button type="button" onclick="document.getElementById('images-picker').click()"
                    style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.45rem 1rem;background:#f3f4f6;border:1.5px dashed #d1d5db;border-radius:0.375rem;font-size:0.85rem;font-weight:600;color:#374151;cursor:pointer;transition:border-color .2s,background .2s;"
                    onmouseover="this.style.borderColor='#2563eb';this.style.background='#eff6ff'"
                    onmouseout="this.style.borderColor='#d1d5db';this.style.background='#f3f4f6'">
                + Tambah Gambar
            </button>
            <p class="text-gray-400 text-xs mt-1">Klik tombol untuk pilih gambar. Bisa diklik berkali-kali untuk gambar dari folder berbeda.</p>

            {{-- Area preview --}}
            <div id="new-image-preview" class="mt-3 flex flex-wrap gap-2"></div>
        </div>

        {{-- Link Marketplace --}}
        <div class="border border-gray-200 rounded-lg p-4 space-y-4">
            <h3 class="text-gray-700 font-semibold">Tersedia di Marketplace <span class="text-gray-400 font-normal text-sm">(opsional)</span></h3>
            <div>
                <label for="shopee_url" class="block text-gray-600 text-sm mb-1">Link Shopee</label>
                <input type="text" name="shopee_url" id="shopee_url" value="{{ old('shopee_url', $product->shopee_url) }}"
                       class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-400 text-sm"
                       placeholder="https://shopee.co.id/...">
            </div>
            <div>
                <label for="tokopedia_url" class="block text-gray-600 text-sm mb-1">Link Tokopedia</label>
                <input type="text" name="tokopedia_url" id="tokopedia_url" value="{{ old('tokopedia_url', $product->tokopedia_url) }}"
                       class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 text-sm"
                       placeholder="https://www.tokopedia.com/...">
            </div>
        </div>

        {{-- URL Video --}}
        <div>
            <label for="video_url" class="block text-gray-700 font-semibold mb-2">
                URL Video Produk <span class="text-gray-400 font-normal text-sm">(opsional — YouTube, dll)</span>
            </label>
            <input type="text" name="video_url" id="video_url" value="{{ old('video_url', $product->video_url) }}"
                   class="w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                   placeholder="https://www.youtube.com/watch?v=...">
        </div>

        {{-- Status Aktif --}}
        <div class="flex items-center">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                   class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
            <label for="is_active" class="ml-2 text-gray-700 font-semibold">Produk Aktif (tampil di website)</label>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-4 pt-4">
            <a href="{{ route('admin.products.index') }}"
               class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 font-semibold transition">Batal</a>
            <button type="submit"
                    class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold transition">
                Perbarui Produk
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    // ── CKEditor ──────────────────────────────────────────
    let productEditor = null;
    ClassicEditor
        .create(document.querySelector('#description_editor'))
        .then(editor => { productEditor = editor; })
        .catch(error => { console.error('CKEditor error:', error); });

    // Sync CKEditor ke textarea sebelum form di-submit
    document.getElementById('edit-product-form').addEventListener('submit', function() {
        if (productEditor) {
            document.querySelector('textarea[name="description"]').value = productEditor.getData();
        }
    });

    // ── Akumulatif Multi-Image Picker ─────────────────────
    let fileStore = new DataTransfer();

    document.getElementById('images-picker').addEventListener('change', function() {
        for (let i = 0; i < this.files.length; i++) {
            fileStore.items.add(this.files[i]);
        }
        document.getElementById('images-real-input').files = fileStore.files;
        renderNewPreview();
        this.value = ''; // Reset picker agar bisa pilih file yang sama lagi
    });

    function removeNewFile(index) {
        const newStore = new DataTransfer();
        for (let i = 0; i < fileStore.files.length; i++) {
            if (i !== index) newStore.items.add(fileStore.files[i]);
        }
        fileStore = newStore;
        document.getElementById('images-real-input').files = fileStore.files;
        renderNewPreview();
    }

    function renderNewPreview() {
        const preview = document.getElementById('new-image-preview');
        preview.innerHTML = '';
        for (let i = 0; i < fileStore.files.length; i++) {
            const file = fileStore.files[i];
            const reader = new FileReader();
            const idx = i;
            reader.onload = function(e) {
                const wrap = document.createElement('div');
                wrap.style.cssText = 'position:relative;width:88px;flex-shrink:0;';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width:88px;height:88px;object-fit:contain;border:1px solid #e5e7eb;border-radius:6px;background:#f9fafb;display:block;';

                const name = document.createElement('p');
                name.textContent = file.name.length > 10 ? file.name.substring(0, 9) + '…' : file.name;
                name.style.cssText = 'font-size:9px;color:#6b7280;text-align:center;margin-top:3px;overflow:hidden;white-space:nowrap;';

                const del = document.createElement('button');
                del.type = 'button';
                del.textContent = '×';
                del.style.cssText = 'position:absolute;top:2px;right:2px;width:18px;height:18px;background:#ef4444;color:#fff;border:none;border-radius:50%;font-size:12px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;';
                del.onclick = function() { removeNewFile(idx); };

                wrap.appendChild(img);
                wrap.appendChild(del);
                wrap.appendChild(name);
                preview.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        }
    }

    // ── Hapus gambar via fetch (tanpa nested form) ────────
    function deleteImage(imgId, url) {
        if (!confirm('Hapus gambar ini?')) return;

        const token = document.querySelector('meta[name="csrf-token"]')
                   || document.querySelector('input[name="_token"]');
        const csrfToken = token
            ? (token.getAttribute('content') || token.value)
            : '{{ csrf_token() }}';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: '_method=DELETE&_token=' + encodeURIComponent(csrfToken),
        })
        .then(res => {
            if (res.ok || res.redirected) {
                const el = document.getElementById('img-wrap-' + imgId);
                if (el) el.remove();
            } else {
                alert('Gagal menghapus gambar. Silakan coba lagi.');
            }
        })
        .catch(() => alert('Terjadi kesalahan jaringan.'));
    }
</script>
@endpush
