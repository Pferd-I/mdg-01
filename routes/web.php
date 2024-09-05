<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevokePfRoleController;
use App\Http\Controllers\RevokePfUserController;
use App\Http\Controllers\RevokeRfUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
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
});

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/users',UserController::class);
    Route::resource('/roles',RoleController::class);
    Route::resource('/permissions',PermissionController::class);
    Route::delete('/roles/{role}/permissions/{permission}', RevokePfRoleController::class)
            ->name('roles.permissions.revoke');
    Route::delete('/user/{user}/roles/{role}', RevokeRfUserController::class)
            ->name('users.roles.revoke');
    Route::delete('/user/{user}/permissions/{permission}', RevokePfUserController::class)
            ->name('users.permissions.revoke');
});

Route::resource('/posts',PostController::class)->middleware('role:admin|profesor');

require __DIR__.'/auth.php';
