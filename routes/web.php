<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEndController;

// Public Routes
// GET requests for main pages are now handled dynamically by PageBuilder at the bottom of this file.
Route::get('/edukasi/{education:slug}', [FrontEndController::class, 'educationDetail'])->name('educations.detail');
Route::get('/berita/{news:slug}', [FrontEndController::class, 'newsDetail'])->name('news.detail');

Route::post('/kontak', [FrontEndController::class, 'storeContact'])->name('contact.store')->middleware('throttle:3,1');
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

    // CRUD Resources
    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);
    Route::resource('work-programs', \App\Http\Controllers\Admin\WorkProgramController::class);
    Route::resource('educations', \App\Http\Controllers\Admin\EducationController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

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

// Dynamic Page Route (MUST BE AT THE BOTTOM)
Route::get('/', [FrontEndController::class, 'showPage'])->defaults('slug', 'home')->name('home');
Route::get('/{slug}', [FrontEndController::class, 'showPage'])->name('page.show');
