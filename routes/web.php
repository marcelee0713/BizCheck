<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\VerificationController;
use Inertia\Inertia;

Route::inertia('/', 'LandingPage')->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/on-board', [ProfileController::class, 'onboard'])->name('onboard');
    Route::get("/profile", [ProfileController::class, 'show'])->name('profile');
    Route::get("/profile-edit", [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete("/profile",  [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get("/submission", [SubmissionController::class, 'create'])->name('submission.create');
    Route::post("/submission", [SubmissionController::class, 'store'])->name('submission.store');
    Route::post("/submission-evaluation", [SubmissionController::class, 'storeAndEvaluate'])->name('submission.store.evaluate');
    Route::delete("/submission/{id}", [SubmissionController::class, 'destroy'])->name('submission.destroy');

    Route::get("/evaluation", [EvaluationController::class, 'index'])->name('evaluations');
    Route::get("/evaluation/{id}", [EvaluationController::class, 'show'])->name('evaluation.chat');
    Route::post("/evaluation/{id}", [EvaluationController::class, 'store'])->name('evaluation.store');
    Route::delete("/evaluation/{id}", [EvaluationController::class, 'destroy'])->name('evaluation.destroy');

    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
    Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');

    Route::post('/chat/{id}', [ResponseController::class, 'store'])->name('chat');

    Route::inertia('/business', 'Business')->name('business');
});
require __DIR__.'/auth.php';




