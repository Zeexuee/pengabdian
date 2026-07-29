<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\FrontEndController;

// ── Test Upload (HAPUS SETELAH SELESAI DEBUG) ──
Route::get('/test-upload', function () {
    return '<!DOCTYPE html><html><body>
    <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="' . csrf_token() . '">
    <p>Pilih beberapa gambar:</p>
    <input type="file" name="images[]" multiple accept="image/*"><br><br>
    <button type="submit">Kirim</button>
    </form></body></html>';
});
Route::post('/test-upload', function (Request $request) {
    $result = ['has_file' => $request->hasFile('images')];
    if ($request->hasFile('images')) {
        $files = $request->file('images');
        if (!is_array($files)) $files = [$files];
        foreach ($files as $i => $f) {
            $result['files'][] = ['index'=>$i,'name'=>$f->getClientOriginalName(),'valid'=>$f->isValid()];
        }
    }
    return response()->json($result);
});
// ── End Test Upload ──

// Public Routes
Route::get('/', [FrontEndController::class, 'home'])->name('home');
Route::get('/struktur-anggota', [FrontEndController::class, 'members'])->name('members');
Route::get('/program-kerja', [FrontEndController::class, 'workPrograms'])->name('work_programs');
Route::get('/program-kerja/{work_program}', [FrontEndController::class, 'workProgramDetail'])->name('work_programs.detail');
Route::get('/edukasi', [FrontEndController::class, 'educations'])->name('educations');
Route::get('/edukasi/{education:slug}', [FrontEndController::class, 'educationDetail'])->name('educations.detail');
Route::get('/berita', [FrontEndController::class, 'news'])->name('news');
Route::get('/berita/{news:slug}', [FrontEndController::class, 'newsDetail'])->name('news.detail');

Route::get('/produk', [FrontEndController::class, 'products'])->name('products');
Route::get('/produk/{product:slug}', [FrontEndController::class, 'productDetail'])->name('products.detail');

Route::get('/kontak', [FrontEndController::class, 'contact'])->name('contact');
Route::post('/kontak', [FrontEndController::class, 'storeContact'])->name('contact.store')->middleware('throttle:3,1');

Route::get('/gabung', [FrontEndController::class, 'join'])->name('join');
Route::post('/gabung', [FrontEndController::class, 'storeJoin'])->name('join.store')->middleware('throttle:3,1');

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Route Group
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan Profil
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // CRUD Divisions & Members
    Route::post('divisions/reorder', [\App\Http\Controllers\Admin\DivisionController::class, 'reorder'])->name('divisions.reorder');
    Route::resource('divisions', \App\Http\Controllers\Admin\DivisionController::class);

    Route::post('members/reorder', [\App\Http\Controllers\Admin\MemberController::class, 'reorderMembers'])->name('members.reorder');
    Route::post('members/sections/reorder', [\App\Http\Controllers\Admin\MemberController::class, 'reorderSections'])->name('members.sections.reorder');
    Route::post('members/sections', [\App\Http\Controllers\Admin\MemberController::class, 'storeSectionImage'])->name('members.sections.store');
    Route::delete('members/sections/{id}', [\App\Http\Controllers\Admin\MemberController::class, 'destroySectionImage'])->name('members.sections.destroy');
    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);
    Route::post('work-programs/reorder', [\App\Http\Controllers\Admin\WorkProgramController::class, 'reorder'])->name('work-programs.reorder');
    Route::resource('work-programs', \App\Http\Controllers\Admin\WorkProgramController::class);
    // Detail / Content Blocks
    Route::get('work-programs/{work_program}/detail', [\App\Http\Controllers\Admin\WorkProgramController::class, 'showDetail'])->name('work-programs.detail');
    Route::post('work-programs/{work_program}/blocks/reorder', [\App\Http\Controllers\Admin\WorkProgramController::class, 'reorderBlocks'])->name('work-programs.blocks.reorder');
    Route::post('work-programs/{work_program}/blocks', [\App\Http\Controllers\Admin\WorkProgramController::class, 'storeBlock'])->name('work-programs.blocks.store');
    Route::put('work-programs/{work_program}/blocks/{block}', [\App\Http\Controllers\Admin\WorkProgramController::class, 'updateBlock'])->name('work-programs.blocks.update');
    Route::delete('work-programs/{work_program}/blocks/{block}', [\App\Http\Controllers\Admin\WorkProgramController::class, 'destroyBlock'])->name('work-programs.blocks.destroy');
    Route::resource('educations', \App\Http\Controllers\Admin\EducationController::class);
    Route::post('news/reorder', [\App\Http\Controllers\Admin\NewsController::class, 'reorder'])->name('news.reorder');
    Route::get('news/{news}/detail', [\App\Http\Controllers\Admin\NewsController::class, 'showDetail'])->name('news.detail');
    Route::post('news/{news}/blocks/reorder', [\App\Http\Controllers\Admin\NewsController::class, 'reorderBlocks'])->name('news.blocks.reorder');
    Route::post('news/{news}/blocks', [\App\Http\Controllers\Admin\NewsController::class, 'storeBlock'])->name('news.blocks.store');
    Route::put('news/{news}/blocks/{block}', [\App\Http\Controllers\Admin\NewsController::class, 'updateBlock'])->name('news.blocks.update');
    Route::delete('news/{news}/blocks/{block}', [\App\Http\Controllers\Admin\NewsController::class, 'destroyBlock'])->name('news.blocks.destroy');
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::delete('products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // Page Builder Home
    Route::post('home-sections/hero/reorder', [\App\Http\Controllers\Admin\HomeSectionController::class, 'reorderHero'])->name('home-sections.hero.reorder');
    Route::post('home-sections/hero', [\App\Http\Controllers\Admin\HomeSectionController::class, 'storeHero'])->name('home-sections.hero.store');
    Route::delete('home-sections/hero/{id}', [\App\Http\Controllers\Admin\HomeSectionController::class, 'destroyHero'])->name('home-sections.hero.destroy');
    Route::post('home-sections/reorder', [\App\Http\Controllers\Admin\HomeSectionController::class, 'reorder'])->name('home-sections.reorder');
    Route::resource('home-sections', \App\Http\Controllers\Admin\HomeSectionController::class);

    // Read, Update (change status), Delete for Contacts & Join Requests
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::put('contacts/{contact}/update-status', [\App\Http\Controllers\Admin\ContactController::class, 'updateStatus'])->name('contacts.update_status');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('join-requests', [\App\Http\Controllers\Admin\JoinRequestController::class, 'index'])->name('join_requests.index');
    Route::get('join-requests/{join_request}', [\App\Http\Controllers\Admin\JoinRequestController::class, 'show'])->name('join_requests.show');
    Route::put('join-requests/{join_request}/update-status', [\App\Http\Controllers\Admin\JoinRequestController::class, 'updateStatus'])->name('join_requests.update_status');
    Route::delete('join-requests/{join_request}', [\App\Http\Controllers\Admin\JoinRequestController::class, 'destroy'])->name('join_requests.destroy');
});
