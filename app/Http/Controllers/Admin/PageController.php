<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content_blocks' => 'nullable|array',
        ]);

        if ($request->hasFile('meta_image')) {
            $validated['meta_image'] = $request->file('meta_image')->store('seo_pages', 'public');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (!empty($request->input('content_blocks'))) {
            $blocks = $request->input('content_blocks');
            foreach ($blocks as $index => &$block) {
                // Handle tipe 'gambar' dan 'file'
                if (in_array($block['type'], ['gambar', 'file']) && $request->hasFile("content_blocks.{$index}.content")) {
                    $block['content'] = $request->file("content_blocks.{$index}.content")->store('pages', 'public');
                }

                // Handle tipe 'video'
                if ($block['type'] === 'video' && $request->hasFile("content_blocks.{$index}.content")) {
                    $file = $request->file("content_blocks.{$index}.content");
                    if ($file->getSize() > 20 * 1024 * 1024) {
                        return back()->withErrors(['content_blocks' => 'Ukuran video pada blok ke-'.($index+1).' tidak boleh melebihi 20MB.'])->withInput();
                    }
                    $block['content'] = $file->store('pages', 'public');
                }
                
                // Handle tipe 'grup_teks_gambar'
                if ($block['type'] === 'grup_teks_gambar' && $request->hasFile("content_blocks.{$index}.content.gambar")) {
                    $block['content']['gambar'] = $request->file("content_blocks.{$index}.content.gambar")->store('pages', 'public');
                }

                // Handle tipe 'slider' dan 'grup_gambar'
                if (in_array($block['type'], ['slider', 'grup_gambar']) && $request->hasFile("content_blocks.{$index}.content")) {
                    $sliderFiles = $request->file("content_blocks.{$index}.content");
                    $paths = [];
                    foreach ($sliderFiles as $sliderFile) {
                        $paths[] = $sliderFile->store('pages', 'public');
                    }
                    $block['content'] = $paths;
                }
            }
            $validated['content_blocks'] = $blocks;
        } else {
            $validated['content_blocks'] = [];
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'content_blocks' => 'nullable|array',
        ]);

        if ($request->hasFile('meta_image')) {
            $validated['meta_image'] = $request->file('meta_image')->store('seo_pages', 'public');
        }

        if (!empty($request->input('content_blocks'))) {
            $blocks = $request->input('content_blocks');
            $oldBlocks = is_array($page->content_blocks) ? $page->content_blocks : [];
            
            foreach ($blocks as $index => &$block) {
                // Handle tipe 'gambar' dan 'file'
                if (in_array($block['type'], ['gambar', 'file'])) {
                    if ($request->hasFile("content_blocks.{$index}.content")) {
                        $block['content'] = $request->file("content_blocks.{$index}.content")->store('pages', 'public');
                    } elseif (isset($oldBlocks[$index]['content'])) {
                        // Pertahankan path lama jika metode adalah update dan tidak ada file baru yang diunggah
                        $block['content'] = $oldBlocks[$index]['content'];
                    }
                }

                // Handle tipe 'video'
                if ($block['type'] === 'video') {
                    if ($request->hasFile("content_blocks.{$index}.content")) {
                        $file = $request->file("content_blocks.{$index}.content");
                        if ($file->getSize() > 20 * 1024 * 1024) {
                            return back()->withErrors(['content_blocks' => 'Ukuran video pada blok ke-'.($index+1).' tidak boleh melebihi 20MB.'])->withInput();
                        }
                        $block['content'] = $file->store('pages', 'public');
                    } elseif (isset($oldBlocks[$index]['content'])) {
                        $block['content'] = $oldBlocks[$index]['content'];
                    }
                }

                // Handle tipe 'grup_teks_gambar'
                if ($block['type'] === 'grup_teks_gambar') {
                    if ($request->hasFile("content_blocks.{$index}.content.gambar")) {
                        $block['content']['gambar'] = $request->file("content_blocks.{$index}.content.gambar")->store('pages', 'public');
                    } elseif (isset($oldBlocks[$index]['content']['gambar'])) {
                        // Pertahankan gambar lama
                        $block['content']['gambar'] = $oldBlocks[$index]['content']['gambar'];
                    }
                }

                // Handle tipe 'slider' dan 'grup_gambar'
                if (in_array($block['type'], ['slider', 'grup_gambar'])) {
                    if ($request->hasFile("content_blocks.{$index}.content")) {
                        $sliderFiles = $request->file("content_blocks.{$index}.content");
                        $paths = [];
                        foreach ($sliderFiles as $sliderFile) {
                            $paths[] = $sliderFile->store('pages', 'public');
                        }
                        $block['content'] = $paths;
                    } elseif (isset($oldBlocks[$index]['content']) && is_array($oldBlocks[$index]['content'])) {
                        $block['content'] = $oldBlocks[$index]['content'];
                    } else {
                        $block['content'] = [];
                    }
                }
            }
            $validated['content_blocks'] = $blocks;
        } else {
            $validated['content_blocks'] = [];
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    public function destroy(Page $page)
    {
        // Prevent deleting default pages if necessary, or just allow deletion.
        $defaultSlugs = ['home', 'struktur-anggota', 'program-kerja', 'edukasi', 'berita', 'kontak', 'gabung'];
        if (in_array($page->slug, $defaultSlugs)) {
            return redirect()->route('admin.pages.index')->withErrors(['error' => 'Halaman default tidak dapat dihapus.']);
        }

        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}
