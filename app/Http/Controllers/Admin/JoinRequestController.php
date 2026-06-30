<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    public function index()
    {
        $query = JoinRequest::latest();
        
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%');
        }
        
        $joinRequests = $query->paginate(10)->withQueryString();
        return view('admin.join-requests.index', compact('joinRequests'));
    }

    public function show(JoinRequest $join_request)
    {
        return view('admin.join-requests.show', compact('join_request'));
    }

    public function updateStatus(Request $request, JoinRequest $join_request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string'
        ]);

        $join_request->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->back()->with('success', 'Status permintaan bergabung berhasil diperbarui.');
    }

    public function destroy(JoinRequest $join_request)
    {
        $join_request->delete();
        return redirect()->route('admin.join_requests.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
