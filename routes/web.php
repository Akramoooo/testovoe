<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/product/{id}', function ($id) {
    return Inertia::render('Products/Show', [
        'id' => $id,
    ]);
});

Route::get('/admin/products', function () {
    return Inertia::render('Admin/Products');
});

Route::get('/admin/products/create', function () {
    return Inertia::render('Admin/Form');
});

Route::get('/admin/products/{id}/edit', function ($id) {
    return Inertia::render('Admin/Form', ['id' => $id]);
});




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
