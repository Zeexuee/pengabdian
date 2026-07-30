<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Education;
use App\Models\JoinRequest;
use App\Models\Member;
use App\Models\News;
use App\Models\Product;
use App\Models\WorkProgram;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function home()
    {
        // Data berita (sesuai urutan drag & drop admin)
        $latest_news = News::where('status', 'published')->orderBy('order', 'asc')->latest('published_at')->take(3)->get();
        
        // Data Program Kerja Unggulan
        $featured_programs = WorkProgram::orderBy('order', 'asc')->take(3)->get();

        // Data Produk Daur Ulang Unggulan
        $featured_products = Product::active()->with('images')->orderBy('order', 'asc')->latest()->take(4)->get();

        // Data Edukasi Unggulan
        $featured_educations = Education::where('is_published', true)->orderBy('order', 'asc')->latest()->take(3)->get();

        // Statistik Ringkasan Dampak
        $stats = [
            'programs' => WorkProgram::count(),
            'products' => Product::active()->count(),
            'educations' => Education::where('is_published', true)->count(),
            'members' => Member::count(),
        ];

        // Data dinamis Page Builder
        $hero_slides = \App\Models\HeroBanner::orderBy('order')->get();
        $sections = \App\Models\HomeSection::where('type', '!=', 'hero')->where('is_active', true)->orderBy('order')->get();

        return view('frontend.home', compact(
            'latest_news', 
            'featured_programs', 
            'featured_products', 
            'featured_educations', 
            'stats', 
            'hero_slides', 
            'sections'
        ));
    }

    public function members()
    {
        $divisions = \App\Models\Division::with(['members' => function($q) {
            $q->orderBy('order', 'asc');
        }])->orderBy('order', 'asc')->get();

        return view('frontend.members', compact('divisions'));
    }

    public function workPrograms()
    {
        // Mengambil semua program kerja sesuai urutan admin
        $workPrograms = WorkProgram::orderBy('order', 'asc')->get();
        return view('frontend.work_programs', compact('workPrograms'));
    }

    public function workProgramDetail($slug)
    {
        $work_program = WorkProgram::where('slug', $slug)
            ->orWhere('id', is_numeric($slug) ? $slug : 0)
            ->firstOrFail();

        $blocks = $work_program->blocks;
        return view('frontend.work_program_detail', compact('work_program', 'blocks'));
    }


    public function educations()
    {
        // Mengambil data edukasi yang dipublikasikan (sesuai urutan drag & drop admin)
        $educations = Education::where('is_published', true)->orderBy('order', 'asc')->latest()->paginate(9);
        return view('frontend.educations', compact('educations'));
    }

    public function educationDetail(Education $education)
    {
        if (!$education->is_published) {
            abort(404);
        }
        $blocks = $education->blocks;
        return view('frontend.edukasi_detail', compact('education', 'blocks'));
    }

    public function news()
    {
        // Mengambil semua berita sesuai urutan drag & drop admin
        $news = News::with('author')->where('status', 'published')->orderBy('order', 'asc')->latest('published_at')->paginate(9);
        return view('frontend.berita', compact('news'));
    }

    public function newsDetail(News $news)
    {
        if ($news->status !== 'published') {
            abort(404);
        }
        $blocks = $news->blocks;
        return view('frontend.berita_detail', compact('news', 'blocks'));
    }

    public function products()
    {
        $products = Product::active()->with('images')->orderBy('order', 'asc')->latest()->paginate(12);
        return view('frontend.products', compact('products'));
    }

    public function productDetail(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }
        $product->load('images');
        // Saran produk lain (mungkin kamu suka) — 4 produk aktif selain produk ini
        $suggestions = Product::active()
            ->with('images')
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('frontend.product_detail', compact('product', 'suggestions'));
    }

    public function contact()
    {
        return view('frontend.kontak');
    }

    public function storeContact(Request $request)
    {
        // Honeypot check
        if ($request->filled('website_url')) {
            abort(403);
        }

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
        // Honeypot check
        if ($request->filled('website_url')) {
            abort(403);
        }

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
