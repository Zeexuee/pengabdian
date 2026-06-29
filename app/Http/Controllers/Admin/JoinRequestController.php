<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class JoinRequestController extends Controller
{
    public function index()
    {
        $joinRequests = JoinRequest::latest()->paginate(15);
        return view('admin.join_requests.index', compact('joinRequests'));
    }

    public function show(JoinRequest $joinRequest)
    {
        return view('admin.join_requests.show', compact('joinRequest'));
    }

    public function updateStatus(Request $request, JoinRequest $joinRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);
        $joinRequest->update(['status' => $request->status]);
        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy(JoinRequest $joinRequest)
    {
        $joinRequest->delete();
        return redirect()->route('admin.join_requests.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}
