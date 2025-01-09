<?php

use App\Http\Controllers\Auth\EmailChangeController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SocialLinksController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'LandingPage')->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('/user-update', [UserController::class, 'update'])->name('update.user');
    Route::get("/change-email", [EmailChangeController::class, 'create'])->name('change_email.create');
    Route::post('/change-email', [EmailChangeController::class, 'store'])->name('change_email.store');
    Route::get('/change-email/{token}/{email}', [EmailChangeController::class, 'verify'])->name('change_email.verify');
    Route::patch('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('/on-board', [ProfileController::class, 'onboard'])->name('onboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete("/profile",  [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/social-links', [SocialLinksController::class, 'update'])->name('social_links.update');

    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submission', [SubmissionController::class, 'create'])->name('submission.create');
    Route::post('/submission', [SubmissionController::class, 'store'])->name('submission.store');
    Route::post('/submission-evaluation', [SubmissionController::class, 'storeAndEvaluate'])->name('submission.store.evaluate');
    Route::delete('/submission/{id}', [SubmissionController::class, 'destroy'])->name('submission.destroy');

    Route::get('/evaluation', [EvaluationController::class, 'index'])->name('evaluations');
    Route::get('/evaluation/{id}', [EvaluationController::class, 'show'])->name('evaluation.chat');
    Route::post('/evaluation/{id}', [EvaluationController::class, 'store'])->name('evaluation.store');
    Route::delete('/evaluation/{id}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy');

    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');

    Route::post('/chat/{id}', [ResponseController::class, 'store'])->name('chat');

    Route::get('/evaluation/form', [EvaluationController::class, 'showForm'])->name('evaluation.form');
});

require __DIR__.'/auth.php';


