<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    CategoryController,
    ArtworkController,
    ServiceController,
    OrderController,
    PaymentController,
    OrderChatController,
    ReviewController,
    ReportController,
    NotificationController,
    ArtistController,
    InvoiceController
};

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminOnly;


// ===================== GUEST / PUBLIC ROUTES =====================
Route::get('/', function () {
    return view('welcome');
})->name('landing');


// ===================== AUTH ROUTES (CUSTOM BY ROLE) =====================
// Login
Route::get('/login', [AuthController::class, 'loginPage'])->name('login.page');
Route::post('/login', [AuthController::class, 'login'])->name('login');



// Register: Buyer
Route::get('/register/buyer', [AuthController::class, 'registerBuyerPage'])->name('register.buyer');
Route::post('/register/buyer', [AuthController::class, 'registerBuyer']);

// Register: Artist
Route::get('/register/artist', [AuthController::class, 'registerArtistPage'])->name('register.artist');
Route::post('/register/artist', [AuthController::class, 'registerArtist']);


// ===================== BUYER ROUTES =====================
Route::middleware(['auth', 'buyer'])
    ->prefix('buyer')
    ->name('buyer.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('buyer.dashboard');
        })->name('dashboard');
    });


// ===================== ARTIST ROUTES =====================
Route::middleware(['auth', 'artist'])
    ->prefix('artist')
    ->name('artist.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('artist.dashboard');
        })->name('dashboard');
    });

// routes/web.php
Route::middleware(['auth', 'artist'])->group(function () {
    Route::patch('orders/{order}/artist-status', [OrderController::class, 'artistUpdateStatus'])
    ->middleware('auth') // optional, karena semua routes resource sudah pakai auth
    ->name('orders.artistUpdateStatus');
});


// ===================== PUBLIC ARTIST PROFILE =====================
Route::get('/artist/{artist}', [ArtistController::class, 'show'])
    ->name('artists.show');


// ===================== ADMIN ROUTES =====================
Route::middleware(['auth', AdminOnly::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    });


// ===================== AUTHENTICATED USER ROUTES (ALL ROLES) =====================
Route::middleware('auth')->group(function () {

    // CRUD
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('artworks', ArtworkController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('orders', OrderController::class);

    // Artist-specific: update order status
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('orders/{order}/wa', [OrderController::class, 'waLink'])->name('orders.wa');

    Route::resource('payments', PaymentController::class)->except(['edit', 'update']);
    Route::post('payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');

    Route::resource('order_chat', OrderChatController::class)->only(['index', 'store', 'destroy']);
    Route::resource('reviews', ReviewController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('reports', ReportController::class)->except(['edit', 'show']);
    Route::post('reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');


    Route::resource('notifications', NotificationController::class)->only(['index', 'destroy']);
    Route::post('notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    // Invoices
    Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);
    Route::get('orders/{order}/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('orders/{order}/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::post('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');

    // Profile (used by layout links)
    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// ===================== LARAVEL DEFAULT AUTH ROUTES =====================
