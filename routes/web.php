<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\SubmissionController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\User\UserDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home.index');
Route::get('/articles', [PublicController::class, 'articles'])->name('articles.index');
Route::get('/articles/{slug}', [PublicController::class, 'articleDetail'])->name('articles.show');
Route::get('/about', [PublicController::class, 'about'])->name('about');

Auth::routes();

// Redirect authenticated users based on role
Route::get('/home', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware('auth')->name('home');

// User Routes
Route::prefix('user')->name('user.')->middleware(['auth', 'isuser'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/submissions', [UserDashboardController::class, 'mySubmissions'])->name('submissions.index');
    Route::get('/submissions/create', [UserDashboardController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [UserDashboardController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}', [UserDashboardController::class, 'show'])->name('submissions.show');
    Route::get('/submissions/{submission}/edit', [UserDashboardController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{submission}', [UserDashboardController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{submission}', [UserDashboardController::class, 'destroy'])->name('submissions.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isadmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
    
    // Submission Review Routes
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/approve', [SubmissionController::class, 'approve'])->name('submissions.approve');
    Route::post('/submissions/{submission}/reject', [SubmissionController::class, 'reject'])->name('submissions.reject');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
});
