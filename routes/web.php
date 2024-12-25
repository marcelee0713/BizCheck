<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'show'])->name('landing');

Route::get('/landing', function () {
    return Inertia::render('Welcome');
})->name("welcome");


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/on-board', [ProfileController::class, 'create'])->name('onboard');

    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

    Route::get("/submission", [SubmissionController::class, 'create'])->name('submission.create');

    Route::post("/submission", [SubmissionController::class, 'storeAndEvaluate'])->name('submission.store.evaluate');

    Route::get("/evaluation/{id}", [EvaluationController::class, 'show'])->name('evaluation.chat');

    Route::post('/evaluation/{id}', [EvaluationController::class, 'create'])->name('evaluation.create');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
