<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontEndController;

// Public Routes
Route::get('/', [FrontEndController::class, 'home'])->name('home');
Route::get('/struktur-anggota', [FrontEndController::class, 'members'])->name('members');
Route::get('/program-kerja', [FrontEndController::class, 'workPrograms'])->name('work_programs');
Route::get('/edukasi', [FrontEndController::class, 'educations'])->name('educations');
Route::get('/berita', [FrontEndController::class, 'news'])->name('news');

Route::get('/kontak', [FrontEndController::class, 'contact'])->name('contact');
Route::post('/kontak', [FrontEndController::class, 'storeContact'])->name('contact.store');

Route::get('/gabung', [FrontEndController::class, 'join'])->name('join');
Route::post('/gabung', [FrontEndController::class, 'storeJoin'])->name('join.store');

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'authenticate']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Route Group
Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    // Dashboard (optional)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD Resources
    Route::resource('members', \App\Http\Controllers\Admin\MemberController::class);
    Route::resource('work-programs', \App\Http\Controllers\Admin\WorkProgramController::class);
    Route::resource('educations', \App\Http\Controllers\Admin\EducationController::class);
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);

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
