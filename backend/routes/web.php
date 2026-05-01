<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LibraryCategoryController;
use App\Http\Controllers\Admin\LibraryFileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/articles/{slug}', [PublicController::class, 'showArticle'])->name('articles.show');
Route::get('/library/{libraryFile}/download', [PublicController::class, 'downloadLibraryFile'])
    ->middleware('auth')
    ->name('library.download');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/guide', [DashboardController::class, 'guide'])->name('guide');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

    Route::get('/library', [LibraryFileController::class, 'index'])->name('library.index');
    Route::post('/library', [LibraryFileController::class, 'store'])->name('library.store');
    Route::post('/library/categories', [LibraryCategoryController::class, 'store'])->name('library.categories.store');
    Route::delete('/library/categories/{libraryCategory}', [LibraryCategoryController::class, 'destroy'])->name('library.categories.destroy');
    Route::patch('/library/{libraryFile}/toggle-visibility', [LibraryFileController::class, 'toggleVisibility'])
        ->name('library.toggle-visibility');
    Route::delete('/library/{libraryFile}', [LibraryFileController::class, 'destroy'])->name('library.destroy');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});
