<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = News::with('author')->orderBy('order', 'asc')->latest('published_at');
        
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        
        $news = $query->paginate(15)->withQueryString();
        return view('admin.news.index', compact('news'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:news,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            News::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'       => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['author_id'] = auth()->id();
        $validated['order'] = News::max('order') + 1;
        
        if ($request->filled('published_at')) {
            $validated['published_at'] = $request->published_at;
        } elseif ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'status'       => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($request->title !== $news->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        }

        if ($request->filled('published_at')) {
            $validated['published_at'] = $request->published_at;
        } elseif ($validated['status'] === 'published' && !$news->published_at) {
            $validated['published_at'] = now();
        }

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
                Storage::disk('public')->delete($news->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        if ($news->thumbnail && Storage::disk('public')->exists($news->thumbnail)) {
            Storage::disk('public')->delete($news->thumbnail);
        }

        foreach ($news->blocks as $block) {
            if ($block->image && Storage::disk('public')->exists($block->image)) {
                Storage::disk('public')->delete($block->image);
            }
            if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
                Storage::disk('public')->delete($block->video_file);
            }
        }

        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    /* ─────────────────────────────────────────
       Content Blocks (Halaman Detail Berita)
    ───────────────────────────────────────── */

    public function showDetail(News $news)
    {
        $blocks = $news->blocks;
        return view('admin.news.detail', compact('news', 'blocks'));
    }

    public function storeBlock(Request $request, News $news)
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

        $lastOrder = $news->blocks()->max('order') ?? -1;

        $data = [
            'news_id'   => $news->id,
            'type'      => $request->type,
            'title'     => $request->title,
            'content'   => $request->content,
            'video_url' => $request->video_url,
            'order'     => $lastOrder + 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news_blocks', 'public');
        }
        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('news_blocks/videos', 'public');
        }

        \App\Models\NewsBlock::create($data);

        return back()->with('success', 'Konten berita berhasil ditambahkan.');
    }

    public function updateBlock(Request $request, News $news, \App\Models\NewsBlock $block)
    {
        abort_if($block->news_id !== $news->id, 403);

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
            $data['image'] = $request->file('image')->store('news_blocks', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
                Storage::disk('public')->delete($block->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('news_blocks/videos', 'public');
        }

        $block->update($data);

        return back()->with('success', 'Konten berita berhasil diperbarui.');
    }

    public function reorderBlocks(Request $request, News $news)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:news_blocks,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            \App\Models\NewsBlock::where('id', $item['id'])
                ->where('news_id', $news->id)
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function destroyBlock(News $news, \App\Models\NewsBlock $block)
    {
        abort_if($block->news_id !== $news->id, 403);

        if ($block->image && Storage::disk('public')->exists($block->image)) {
            Storage::disk('public')->delete($block->image);
        }
        if ($block->video_file && Storage::disk('public')->exists($block->video_file)) {
            Storage::disk('public')->delete($block->video_file);
        }

        $block->delete();

        return back()->with('success', 'Konten berita berhasil dihapus.');
    }
}
