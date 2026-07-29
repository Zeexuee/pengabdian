<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Simpan file gambar ke public/images/products/ dan kembalikan path relatif.
     * Path disimpan dalam format: images/products/filename.ext
     */
    private function saveImage($file): string
    {
        $dir = public_path('images/products');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return 'images/products/' . $filename;
    }

    /**
     * Hapus file gambar dari public folder.
     */
    private function deleteImage(string $path): void
    {
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function index()
    {
        $query = Product::with('images')->orderBy('order', 'asc')->latest();

        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        $products = $query->paginate(10)->withQueryString();
        return view('admin.products.index', compact('products'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:products,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Product::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|string|max:255',
            'category'      => 'nullable|string|max:255',
            'shopee_url'    => 'nullable|string|max:500',
            'tokopedia_url' => 'nullable|string|max:500',
            'whatsapp_url'  => 'nullable|string|max:500',
            'video_url'     => 'nullable|string|max:500',
            'is_active'     => 'boolean',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        $data = $request->only([
            'name', 'description', 'price', 'category',
            'shopee_url', 'tokopedia_url', 'whatsapp_url', 'video_url',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $product = Product::create($data);

        // Simpan semua gambar yang diupload
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $index => $file) {
                if ($file && $file->isValid()) {
                    $path = $this->saveImage($file);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $path,
                        'order'      => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'price'         => 'nullable|string|max:255',
            'category'      => 'nullable|string|max:255',
            'shopee_url'    => 'nullable|string|max:500',
            'tokopedia_url' => 'nullable|string|max:500',
            'whatsapp_url'  => 'nullable|string|max:500',
            'video_url'     => 'nullable|string|max:500',
            'is_active'     => 'boolean',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,webp|max:8192',
        ]);

        $data = $request->only([
            'name', 'description', 'price', 'category',
            'shopee_url', 'tokopedia_url', 'whatsapp_url', 'video_url',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        // Regenerate slug jika nama berubah
        if ($request->name !== $product->name) {
            $data['slug'] = Product::generateUniqueSlug($request->name, $product->id);
        }

        $product->update($data);

        // Jika ada gambar baru → hapus semua gambar lama, ganti dengan yang baru
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            if (!is_array($files)) {
                $files = [$files];
            }

            $validFiles = array_filter($files, fn($f) => $f && $f->isValid());

            if (!empty($validFiles)) {
                // Hapus file & record lama
                foreach ($product->images as $oldImg) {
                    $this->deleteImage($oldImg->image);
                }
                $product->images()->delete();

                // Simpan gambar baru
                foreach (array_values($validFiles) as $index => $file) {
                    $path = $this->saveImage($file);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $path,
                        'order'      => $index,
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            $this->deleteImage($img->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Hapus satu gambar produk via AJAX.
     */
    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_if($image->product_id !== $product->id, 403);

        $this->deleteImage($image->image);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
