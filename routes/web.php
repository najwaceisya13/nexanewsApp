<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
| Routes yang bisa diakses oleh semua orang (tanpa login)
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
Route::get('/articles/{slug}', [HomeController::class, 'show'])->name('articles.show');

// Comment routes (publik, tapi bisa dari login atau anonymous)
Route::post('/articles/{article}/comments', [CommentController::class, 'store'])->name('comments.store');

// Like routes (publik, bisa dari login atau anonymous dengan session)
Route::post('/articles/{article}/like', [LikeController::class, 'toggle'])->name('likes.toggle');
Route::get('/articles/{article}/likes-count', [LikeController::class, 'getCount'])->name('likes.count');

// Visitor Feedback route (publik)
Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Routes yang hanya bisa diakses admin (protected by admin middleware)
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Article Management (Resource Controller)
    Route::resource('articles', ArticleController::class);

    // Category Management (Resource Controller)
    Route::resource('categories', CategoryController::class);

    // Comment Moderation
    Route::get('/comments', [AdminController::class, 'comments'])->name('admin.comments');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/reject', [CommentController::class, 'reject'])->name('comments.reject');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Notification Routes
    Route::patch('/notifications/{notification}/read', [AdminController::class, 'readNotification'])->name('notifications.read');
    Route::patch('/notifications/read-all', [AdminController::class, 'readAllNotifications'])->name('notifications.readAll');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');

    // Feedback Management Routes
    Route::get('/feedback', [\App\Http\Controllers\FeedbackController::class, 'index'])->name('admin.feedback');
    Route::delete('/feedback/{feedback}', [\App\Http\Controllers\FeedbackController::class, 'destroy'])->name('admin.feedback.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication & Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
