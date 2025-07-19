<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/auctions/index', [AuctionController::class, 'index'])->name('auctions.Index');
    Route::get('/auctions/list', [AuctionController::class, 'list'])->name('auctions.list');

    Route::middleware([IsAdmin::class])->group(function () {
        Route::get('/auctions/create', [AuctionController::class, 'create']);
        Route::post('/auctions/store', [AuctionController::class, 'store'])->name('auctions.store');
        Route::get('/auctions/show/{id}', [AuctionController::class, 'show'])->name('auctions.show');
        Route::get('/auctions/edit/{id}', [AuctionController::class, 'edit'])->name('auctions.edit');
        Route::patch('/auctions/update/{auction}', [AuctionController::class, 'update'])->name('auctions.update');
        Route::delete('/auctions/delete/{auction}', [AuctionController::class, 'destroy'])->name('auctions.delete');
    });

    
    Route::post('/bids/create', [BidController::class, 'store']);
    

});

require __DIR__.'/auth.php';
