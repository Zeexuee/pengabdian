<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\EducationBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EducationController extends Controller
{
    public function index()
    {
        $query = Education::orderBy('order', 'asc')->latest();
        
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        
        $educations = $query->paginate(15)->withQueryString();
        return view('admin.educations.index', compact('educations'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:educations,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Education::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.educations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'video_url'    => 'nullable|url|max:500',
            'is_published' => 'required|boolean'
        ]);

        $data = $request->except('thumbnail');
        $data['slug'] = Str::slug($request->title) . '-' . time();
        $data['order'] = Education::max('order') + 1;

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
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'video_url'    => 'nullable|url|max:500',
            'is_published' => 'required|boolean'
        ]);

        $data = $request->except('thumbnail');
        
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

        foreach ($education->blocks as $block) {
            if ($block->image && Storage::disk('public')->exists($block->image)) {
                Storage::disk('public')->delete($block->image);
            }
            if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
                Storage::disk('public')->delete($block->video_file);
            }
        }
        
        $education->delete();

        return redirect()->route('admin.educations.index')->with('success', 'Materi edukasi berhasil dihapus.');
    }

    /* ─────────────────────────────────────────
       Content Blocks (Halaman Detail Edukasi)
    ───────────────────────────────────────── */

    public function showDetail(Education $education)
    {
        $blocks = $education->blocks;
        return view('admin.educations.detail', compact('education', 'blocks'));
    }

    public function storeBlock(Request $request, Education $education)
    {
        $request->validate([
            'type'       => 'required|in:image,video,text',
            'title'      => 'nullable|string|max:255',
            'content'    => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'video_url'  => 'nullable|url|max:500',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,qt,mov|max:102400',
        ]);

        if ($request->type === 'image' && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'Gambar wajib diupload untuk tipe "Gambar".']);
        }
        if ($request->type === 'video' && empty($request->video_url) && !$request->hasFile('video_file')) {
            return back()->withErrors(['video_file' => 'Upload file video atau isi URL YouTube untuk tipe "Video".']);
        }

        $lastOrder = $education->blocks()->max('order') ?? -1;

        $data = [
            'education_id' => $education->id,
            'type'         => $request->type,
            'title'        => $request->title,
            'content'      => $request->content,
            'video_url'    => $request->video_url,
            'order'        => $lastOrder + 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('education_blocks', 'public');
        }
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('education_blocks/videos', 'public');
        }

        EducationBlock::create($data);

        return back()->with('success', 'Konten edukasi berhasil ditambahkan.');
    }

    public function updateBlock(Request $request, Education $education, EducationBlock $block)
    {
        abort_if($block->education_id !== $education->id, 403);

        $request->validate([
            'type'       => 'required|in:image,video,text',
            'title'      => 'nullable|string|max:255',
            'content'    => 'nullable|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'video_url'  => 'nullable|url|max:500',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg,qt,mov|max:102400',
        ]);

        $data = [
            'type'      => $request->type,
            'title'     => $request->title,
            'content'   => $request->content,
            'video_url' => $request->video_url,
        ];

        if ($request->hasFile('image')) {
            if ($block->image && Storage::disk('public')->exists($block->image)) {
                Storage::disk('public')->delete($block->image);
            }
            $data['image'] = $request->file('image')->store('education_blocks', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
                Storage::disk('public')->delete($block->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('education_blocks/videos', 'public');
        }

        $block->update($data);

        return back()->with('success', 'Konten edukasi berhasil diperbarui.');
    }

    public function reorderBlocks(Request $request, Education $education)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:education_blocks,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            EducationBlock::where('id', $item['id'])
                ->where('education_id', $education->id)
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function destroyBlock(Education $education, EducationBlock $block)
    {
        abort_if($block->education_id !== $education->id, 403);

        if ($block->image && Storage::disk('public')->exists($block->image)) {
            Storage::disk('public')->delete($block->image);
        }
        if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
            Storage::disk('public')->delete($block->video_file);
        }

        $block->delete();

        return back()->with('success', 'Konten edukasi berhasil dihapus.');
    }
}
