<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Member;
use App\Models\MemberPageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        $query = Member::with('division')->orderBy('order', 'asc');
        
        if (request('search')) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('position', 'like', '%' . request('search') . '%')
                  ->orWhereHas('division', function($sub) {
                      $sub->where('name', 'like', '%' . request('search') . '%');
                  });
            });
        }
        
        $members = $query->paginate(10)->withQueryString();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $divisions = Division::orderBy('order', 'asc')->get();
        return view('admin.members.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'order' => 'required|integer'
        ]);

        $data = $request->except('photo');

        if ($request->filled('division_id')) {
            $div = Division::find($request->division_id);
            if ($div) {
                $data['division'] = $div->name;
            }
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        Member::create($data);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(Member $member)
    {
        $divisions = Division::orderBy('order', 'asc')->get();
        return view('admin.members.edit', compact('member', 'divisions'));
    }

    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'division_id' => 'nullable|exists:divisions,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
            'order' => 'required|integer'
        ]);

        $data = $request->except('photo');

        if ($request->filled('division_id')) {
            $div = Division::find($request->division_id);
            if ($div) {
                $data['division'] = $div->name;
            }
        }

        if ($request->hasFile('photo')) {
            if ($member->photo && Storage::disk('public')->exists($member->photo)) {
                Storage::disk('public')->delete($member->photo);
            }
            $data['photo'] = $request->file('photo')->store('members', 'public');
        }

        $member->update($data);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->photo && Storage::disk('public')->exists($member->photo)) {
            Storage::disk('public')->delete($member->photo);
        }
        
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }

    // ─── Member Page Sections ─────────────────────────────────────────

    public function storeSectionImage(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'position'  => 'required|in:above,below',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('member_sections', 'public');
                MemberPageSection::create([
                    'image'    => $path,
                    'order'    => MemberPageSection::max('order') + 1,
                    'position' => $request->input('position', 'below'),
                ]);
            }
        }

        return back()->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function destroySectionImage($id)
    {
        $section = MemberPageSection::findOrFail($id);
        Storage::disk('public')->delete($section->image);
        $section->delete();
        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function reorderMembers(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:members,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            Member::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }

    public function reorderSections(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:member_page_sections,id',
            'orders.*.order' => 'required|integer',
        ]);

        foreach ($request->orders as $item) {
            MemberPageSection::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
