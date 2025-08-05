<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

// Property actions (require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/properties/{property}/favorite', [PropertyController::class, 'toggleFavorite'])->name('properties.favorite');

    // Contact Owner routes (Step 1)
    Route::get('/properties/{property}/contact', [App\Http\Controllers\ContactController::class, 'create'])->name('properties.contact.create');
    Route::post('/properties/{property}/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('properties.contact.store');

    // Appointment routes (Step 2)
    Route::get('/properties/{property}/appointments/create', [App\Http\Controllers\AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/properties/{property}/appointments', [App\Http\Controllers\AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [App\Http\Controllers\AppointmentController::class, 'show'])->name('appointments.show');
    Route::patch('/appointments/{appointment}/status', [App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('appointments.update-status');

    //! to change this step 3 Payment routes (Step 3)
    Route::get('/properties/{property}/payment', [App\Http\Controllers\PaymentController::class, 'create'])->name('payments.create');
    Route::post('/properties/{property}/payment/checkout', [App\Http\Controllers\PaymentController::class, 'createCheckoutSession'])->name('payments.checkout');
    Route::get('/properties/{property}/payment/success', [App\Http\Controllers\PaymentController::class, 'success'])->name('payments.success');
});

// Stripe webhook (no auth required)
Route::post('/stripe/webhook', [App\Http\Controllers\Owner\PaymentController::class, 'webhook'])->name('stripe.webhook');

// Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Redirect dashboard based on user role
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'owner') {
            return redirect()->route('owner.dashboard');
        } elseif ($user->role === 'client') {
            return redirect()->route('client.dashboard');
        }

        return redirect()->route('home');
    })->name('dashboard');

    // Client Routes
    Route::prefix('client')->name('client.')->middleware('role:client')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/favorites', [App\Http\Controllers\Client\FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{property}', [App\Http\Controllers\Client\FavoriteController::class, 'store'])->name('favorites.store');
        Route::delete('/favorites/{property}', [App\Http\Controllers\Client\FavoriteController::class, 'destroy'])->name('favorites.destroy');
        Route::get('/appointments', [App\Http\Controllers\Client\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/properties', function() { return view('client.properties.index'); })->name('properties.index');
    });

    // Owner Routes
    Route::prefix('owner')->name('owner.')->middleware('role:owner')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('properties', App\Http\Controllers\Owner\PropertyController::class);
        Route::get('/appointments', [App\Http\Controllers\Owner\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/data', [App\Http\Controllers\Owner\AppointmentController::class, 'getAppointments'])->name('appointments.data');
        Route::post('/appointments/{appointment}/status', [App\Http\Controllers\Owner\AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
        Route::get('/payments', [App\Http\Controllers\Owner\PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/create', [App\Http\Controllers\Owner\PaymentController::class, 'create'])->name('payments.create');
        Route::post('/payments/checkout', [App\Http\Controllers\Owner\PaymentController::class, 'createCheckoutSession'])->name('payments.checkout');
        Route::get('/payments/{payment}/success', [App\Http\Controllers\Owner\PaymentController::class, 'success'])->name('payments.success');
        Route::get('/payments/{payment}/cancel', [App\Http\Controllers\Owner\PaymentController::class, 'cancel'])->name('payments.cancel');
    });

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function() { return view('admin.dashboard'); })->name('dashboard');

        // User Management
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::post('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('/users/bulk-update', [App\Http\Controllers\Admin\UserController::class, 'bulkUpdate'])->name('users.bulk-update');

        // Property Management
        Route::get('/properties', [App\Http\Controllers\Admin\PropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/{property}', [App\Http\Controllers\Admin\PropertyController::class, 'show'])->name('properties.show');
        Route::put('/properties/{property}/status', [App\Http\Controllers\Admin\PropertyController::class, 'updateStatus'])->name('properties.update-status');
        Route::delete('/properties/{property}', [App\Http\Controllers\Admin\PropertyController::class, 'destroy'])->name('properties.destroy');
        Route::post('/properties/bulk-update', [App\Http\Controllers\Admin\PropertyController::class, 'bulkUpdate'])->name('properties.bulk-update');

        Route::get('/payments', function() { return view('admin.payments.index'); })->name('payments.index');

        // Category Management
        Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
