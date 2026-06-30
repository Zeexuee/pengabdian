<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Member;
use App\Models\WorkProgram;
use App\Models\JoinRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman Dasbor Admin dengan metrik.
     */
    public function index()
    {
        // Agregasi Data
        $totalNews = News::count();
        $totalMembers = Member::count();
        
        // Program kerja aktif (ongoing)
        $activePrograms = WorkProgram::where('status', 'ongoing')->count();
        
        // Permintaan gabung yang masih menunggu persetujuan (pending)
        $pendingRequests = JoinRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalNews', 
            'totalMembers', 
            'activePrograms', 
            'pendingRequests'
        ));
    }
}
