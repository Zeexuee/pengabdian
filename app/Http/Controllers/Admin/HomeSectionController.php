<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSection;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSectionController extends Controller
{
    public function index()
    {
        $heroes = HeroBanner::orderBy('order')->get();
        $sections = HomeSection::where('type', '!=', 'hero')->orderBy('order')->get();
        return view('admin.home-sections.index', compact('sections', 'heroes'));
    }

    public function create()
    {
        return view('admin.home-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:image,text,image_text,video',
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
        $validated['order'] = HomeSection::max('order') + 1;

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
        $validated = $request->validate([
            'type' => 'required|in:image,text,image_text,video',
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
