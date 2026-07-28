<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkProgram;
use App\Models\WorkProgramBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkProgramController extends Controller
{
    /* ─────────────────────────────────────────
       CRUD Program Kerja (list / create / edit)
    ───────────────────────────────────────── */

    public function index()
    {
        $query = WorkProgram::orderBy('order', 'asc');

        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }

        $workPrograms = $query->paginate(15)->withQueryString();
        return view('admin.work-programs.index', compact('workPrograms'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders'         => 'required|array',
            'orders.*.id'    => 'required|integer|exists:work_programs,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            WorkProgram::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function create()
    {
        return view('admin.work-programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'schedule'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date' . ($request->filled('start_date') ? '|after_or_equal:start_date' : ''),
            'status'      => 'required|in:planned,ongoing,completed',
        ]);

        $data = $request->except('image');
        $data['order'] = WorkProgram::max('order') + 1;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('work_programs', 'public');
        }

        WorkProgram::create($data);

        return redirect()->route('admin.work-programs.index')
            ->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(WorkProgram $work_program)
    {
        return view('admin.work-programs.edit', compact('work_program'));
    }

    public function update(Request $request, WorkProgram $work_program)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'schedule'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'start_date'  => 'nullable|date',
            'end_date'    => 'nullable|date' . ($request->filled('start_date') ? '|after_or_equal:start_date' : ''),
            'status'      => 'required|in:planned,ongoing,completed',
        ]);

        $data = $request->except('image');

        // Regenerate slug jika title berubah
        if ($request->title !== $work_program->title) {
            $data['slug'] = WorkProgram::generateUniqueSlug($request->title, $work_program->id);
        }

        if ($request->hasFile('image')) {
            if ($work_program->image && Storage::disk('public')->exists($work_program->image)) {
                Storage::disk('public')->delete($work_program->image);
            }
            $data['image'] = $request->file('image')->store('work_programs', 'public');
        }

        $work_program->update($data);

        return redirect()->route('admin.work-programs.index')
            ->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(WorkProgram $work_program)
    {
        // Hapus gambar cover
        if ($work_program->image && Storage::disk('public')->exists($work_program->image)) {
            Storage::disk('public')->delete($work_program->image);
        }

        // Hapus gambar di blocks
        foreach ($work_program->blocks as $block) {
            if ($block->image && Storage::disk('public')->exists($block->image)) {
                Storage::disk('public')->delete($block->image);
            }
        }

        $work_program->delete();

        return redirect()->route('admin.work-programs.index')
            ->with('success', 'Program kerja berhasil dihapus.');
    }

    /* ─────────────────────────────────────────
       Content Blocks (Halaman Detail)
    ───────────────────────────────────────── */

    /**
     * Tampilkan halaman kelola blocks untuk satu program kerja.
     */
    public function showDetail(WorkProgram $work_program)
    {
        $blocks = $work_program->blocks;
        return view('admin.work-programs.detail', compact('work_program', 'blocks'));
    }

    /**
     * Simpan block baru.
     */
    public function storeBlock(Request $request, WorkProgram $work_program)
    {
        $request->validate([
            'type'      => 'required|in:image,video,text',
            'title'     => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'video_url' => 'nullable|url|max:500',
        ]);

        // Validasi tambahan per-tipe
        if ($request->type === 'image' && !$request->hasFile('image')) {
            return back()->withErrors(['image' => 'Gambar wajib diupload untuk tipe "Gambar".']);
        }
        if ($request->type === 'video' && empty($request->video_url)) {
            return back()->withErrors(['video_url' => 'URL video wajib diisi untuk tipe "Video".']);
        }

        $lastOrder = $work_program->blocks()->max('order') ?? -1;

        $data = [
            'work_program_id' => $work_program->id,
            'type'            => $request->type,
            'title'           => $request->title,
            'content'         => $request->content,
            'video_url'       => $request->video_url,
            'order'           => $lastOrder + 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('work_program_blocks', 'public');
        }

        WorkProgramBlock::create($data);

        return back()->with('success', 'Konten berhasil ditambahkan.');
    }

    /**
     * Perbarui block yang sudah ada.
     */
    public function updateBlock(Request $request, WorkProgram $work_program, WorkProgramBlock $block)
    {
        abort_if($block->work_program_id !== $work_program->id, 403);

        $request->validate([
            'type'      => 'required|in:image,video,text',
            'title'     => 'nullable|string|max:255',
            'content'   => 'nullable|string',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:8192',
            'video_url' => 'nullable|url|max:500',
        ]);

        if ($request->type === 'video' && empty($request->video_url)) {
            return back()->withErrors(['video_url' => 'URL video wajib diisi untuk tipe "Video".']);
        }

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
            $data['image'] = $request->file('image')->store('work_program_blocks', 'public');
        }

        $block->update($data);

        return back()->with('success', 'Konten berhasil diperbarui.');
    }

    /**
     * Hapus block.
     */
    public function destroyBlock(WorkProgram $work_program, WorkProgramBlock $block)
    {
        // Pastikan block milik program ini
        abort_if($block->work_program_id !== $work_program->id, 403);

        if ($block->image && Storage::disk('public')->exists($block->image)) {
            Storage::disk('public')->delete($block->image);
        }

        $block->delete();

        return back()->with('success', 'Konten berhasil dihapus.');
    }
}
