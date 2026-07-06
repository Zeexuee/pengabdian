<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HandlesBlockContent;

class WorkProgramController extends Controller
{
    use HandlesBlockContent;
    public function index()
    {
        $query = WorkProgram::latest();
        
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%');
        }
        
        $workPrograms = $query->paginate(10)->withQueryString();
        return view('admin.work-programs.index', compact('workPrograms'));
    }

    public function create()
    {
        return view('admin.work-programs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string', // dipertahankan sebagai ringkasan
            'content_blocks' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,ongoing,completed'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('work_programs', 'public');
        }

        $data['content_blocks'] = $this->processBlockContent($request);

        WorkProgram::create($data);

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(WorkProgram $work_program)
    {
        return view('admin.work-programs.edit', compact('work_program'));
    }

    public function update(Request $request, WorkProgram $work_program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_blocks' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:planned,ongoing,completed'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($work_program->image && Storage::disk('public')->exists($work_program->image)) {
                Storage::disk('public')->delete($work_program->image);
            }
            $data['image'] = $request->file('image')->store('work_programs', 'public');
        }

        $data['content_blocks'] = $this->processBlockContent($request, $work_program->content_blocks);

        $work_program->update($data);

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(WorkProgram $work_program)
    {
        if ($work_program->image && Storage::disk('public')->exists($work_program->image)) {
            Storage::disk('public')->delete($work_program->image);
        }
        
        $work_program->delete();

        return redirect()->route('admin.work-programs.index')->with('success', 'Program kerja berhasil dihapus.');
    }
}
