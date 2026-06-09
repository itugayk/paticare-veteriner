<?php

use App\Http\Controllers\Auth\OwnerAuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VetController;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------------------------
// Public
// ---------------------------------------------------------------------------
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/hizmetler', [ServiceController::class, 'index'])->name('services');
Route::get('/hizmetler/{service}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/hekimler', [VetController::class, 'index'])->name('vets');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/iletisim', [PageController::class, 'contact'])->name('contact');
Route::post('/iletisim', [PageController::class, 'contactStore'])->name('contact.store');

Route::view('/randevu', 'pages.appointment')->name('appointment');

// ---------------------------------------------------------------------------
// Pet owner authentication
// ---------------------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/giris', [OwnerAuthController::class, 'showLogin'])->name('login');
    Route::post('/giris', [OwnerAuthController::class, 'login']);
    Route::get('/kayit', [OwnerAuthController::class, 'showRegister'])->name('register');
    Route::post('/kayit', [OwnerAuthController::class, 'register']);
});

Route::post('/cikis', [OwnerAuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---------------------------------------------------------------------------
// Pet owner area
// ---------------------------------------------------------------------------
Route::middleware('auth')->prefix('panel')->name('owner.')->group(function () {
    Route::get('/', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/dostlar/yeni', [OwnerController::class, 'petCreate'])->name('pets.create');
    Route::post('/dostlar', [OwnerController::class, 'petStore'])->name('pets.store');
    Route::get('/dostlar/{pet}', [OwnerController::class, 'petShow'])->name('pets.show');
    Route::get('/dostlar/{pet}/duzenle', [OwnerController::class, 'petEdit'])->name('pets.edit');
    Route::put('/dostlar/{pet}', [OwnerController::class, 'petUpdate'])->name('pets.update');
});
