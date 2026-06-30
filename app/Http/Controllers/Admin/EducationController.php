<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function index()
    {
        $query = Education::latest();
        
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        
        $educations = $query->paginate(10)->withQueryString();
        return view('admin.educations.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.educations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url|max:255',
            'is_published' => 'required|boolean'
        ]);

        $data = $request->except('thumbnail');
        $data['slug'] = Str::slug($request->title) . '-' . time();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('educations', 'public');
        }

        Education::create($data);

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil ditambahkan.');
    }

    public function edit(Education $education)
    {
        return view('admin.educations.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url|max:255',
            'is_published' => 'required|boolean'
        ]);

        $data = $request->except('thumbnail');
        
        // Hanya update slug jika title berubah
        if ($request->title !== $education->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('thumbnail')) {
            if ($education->thumbnail && Storage::disk('public')->exists($education->thumbnail)) {
                Storage::disk('public')->delete($education->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('educations', 'public');
        }

        $education->update($data);

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil diperbarui.');
    }

    public function destroy(Education $education)
    {
        if ($education->thumbnail && Storage::disk('public')->exists($education->thumbnail)) {
            Storage::disk('public')->delete($education->thumbnail);
        }
        
        $education->delete();

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil dihapus.');
    }
}
