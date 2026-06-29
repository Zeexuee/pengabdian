<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Education;
use App\Models\JoinRequest;
use App\Models\Member;
use App\Models\News;
use App\Models\WorkProgram;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function home()
    {
        // Menampilkan sekilas data untuk halaman beranda (contoh: 3 berita terbaru)
        $latest_news = News::where('status', 'published')->latest('published_at')->take(3)->get();
        return view('frontend.home', compact('latest_news'));
    }

    public function members()
    {
        // Mengambil semua anggota berdasarkan urutan
        $members = Member::orderBy('order', 'asc')->get();
        return view('frontend.members', compact('members'));
    }

    public function workPrograms()
    {
        // Mengambil semua program kerja
        $workPrograms = WorkProgram::latest()->get();
        return view('frontend.work_programs', compact('workPrograms'));
    }

    public function educations()
    {
        // Mengambil data edukasi yang dipublikasikan
        $educations = Education::where('is_published', true)->latest()->get();
        return view('frontend.educations', compact('educations'));
    }

    public function news()
    {
        // Mengambil semua berita dengan pagination
        $news = News::with('author')->where('status', 'published')->latest('published_at')->paginate(9);
        return view('frontend.berita', compact('news'));
    }

    public function contact()
    {
        return view('frontend.kontak');
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim. Kami akan segera merespons.');
    }

    public function join()
    {
        return view('frontend.gabung');
    }

    public function storeJoin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'reason' => 'required|string',
        ]);

        JoinRequest::create($validated);

        return back()->with('success', 'Permintaan bergabung Anda berhasil dikirim. Menunggu persetujuan admin.');
    }
}
