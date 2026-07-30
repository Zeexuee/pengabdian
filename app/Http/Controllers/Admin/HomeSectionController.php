<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    private function ensureDefaultSectionsExist()
    {
        $defaults = [
            ['type' => 'hero', 'title' => 'Banner Hero Utama (Slider)'],
            ['type' => 'system_program_kerja', 'title' => 'Program Kerja (Highlight)'],
            ['type' => 'system_produk', 'title' => 'Produk Daur Ulang (Highlight)'],
            ['type' => 'system_edukasi', 'title' => 'Edukasi Lingkungan (Highlight)'],
            ['type' => 'system_berita', 'title' => 'Berita Terbaru (Highlight)'],
        ];

        foreach ($defaults as $def) {
            if (!HomeSection::where('type', $def['type'])->exists()) {
                HomeSection::create([
                    'type' => $def['type'],
                    'title' => $def['title'],
                    'order' => (HomeSection::max('order') ?? 0) + 1,
                    'is_active' => true,
                ]);
            }
        }
    }

    public function index()
    {
        $this->ensureDefaultSectionsExist();
        $heroes = HeroBanner::orderBy('order')->get();
        $sections = HomeSection::orderBy('order', 'asc')->get();
        return view('admin.home-sections.index', compact('sections', 'heroes'));
    }

    public function create()
    {
        return view('admin.home-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,text,image_text,video,callout,faq',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image_position' => 'nullable|in:left,right',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['order'] = (HomeSection::max('order') ?? 0) + 1;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('home_sections', 'public');
        }

        HomeSection::create($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'Komponen berhasil ditambahkan.');
    }

    public function edit(HomeSection $homeSection)
    {
        return view('admin.home-sections.edit', compact('homeSection'));
    }

    public function update(Request $request, HomeSection $homeSection)
    {
        $allowedTypes = 'image,text,image_text,video,callout,faq,hero,system_program_kerja,system_produk,system_edukasi,system_berita';
        $validated = $request->validate([
            'type' => 'required|in:' . $allowedTypes,
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'nullable|url|max:255',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'image_position' => 'nullable|in:left,right',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($homeSection->image) {
                Storage::disk('public')->delete($homeSection->image);
            }
            $validated['image'] = $request->file('image')->store('home_sections', 'public');
        }

        $homeSection->update($validated);

        return redirect()->route('admin.home-sections.index')->with('success', 'Komponen berhasil diperbarui.');
    }

    public function destroy(HomeSection $homeSection)
    {
        // Don't allow deletion of system sections to prevent breaking essential page highlights
        if (str_starts_with($homeSection->type, 'system_') || $homeSection->type === 'hero') {
            return back()->with('error', 'Komponen bawaan sistem tidak dapat dihapus. Anda dapat menonaktifkannya jika tidak ingin ditampilkan.');
        }

        if ($homeSection->image) {
            Storage::disk('public')->delete($homeSection->image);
        }
        $homeSection->delete();
        return redirect()->route('admin.home-sections.index')->with('success', 'Komponen berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:home_sections,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            HomeSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus(HomeSection $homeSection)
    {
        $homeSection->update([
            'is_active' => !$homeSection->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $homeSection->is_active,
            'message' => 'Status komponen berhasil diperbarui.'
        ]);
    }

    public function storeHero(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072'
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('hero_banners', 'public');
                HeroBanner::create([
                    'image' => $path,
                    'order' => HeroBanner::max('order') + 1
                ]);
            }
        }

        return back()->with('success', 'Gambar Hero berhasil ditambahkan.');
    }

    public function destroyHero($id)
    {
        $hero = HeroBanner::findOrFail($id);
        Storage::disk('public')->delete($hero->image);
        $hero->delete();
        return back()->with('success', 'Gambar Hero berhasil dihapus.');
    }

    public function reorderHero(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:hero_banners,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            HeroBanner::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
