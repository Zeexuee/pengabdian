<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::withCount('members')->orderBy('order', 'asc')->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('admin.divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);
        $data['order'] = Division::max('order') + 1;

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('divisions', 'public');
        }

        Division::create($data);

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi baru berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        return view('admin.divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('banner_image')) {
            if ($division->banner_image && Storage::disk('public')->exists($division->banner_image)) {
                Storage::disk('public')->delete($division->banner_image);
            }
            $data['banner_image'] = $request->file('banner_image')->store('divisions', 'public');
        }

        $division->update($data);

        return redirect()->route('admin.divisions.index')->with('success', 'Data divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        if ($division->banner_image && Storage::disk('public')->exists($division->banner_image)) {
            Storage::disk('public')->delete($division->banner_image);
        }

        $division->delete();

        return redirect()->route('admin.divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:divisions,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Division::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
