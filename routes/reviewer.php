<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Reviewer\PPM\PenelitianController;
use App\Http\Controllers\Reviewer\PPM\PengabdianController;

/*
|-------------------------------------------------------------------------- 
| Reviewer Routes 
|-------------------------------------------------------------------------- 
| 
| These routes are specifically for reviewers. 
| They are protected by middleware to ensure only users with the "reviewer" role 
| have access to them. 
| 
*/

Route::middleware(['auth', 'role:reviewer'])->group(function () {
    Route::resource('ppm/penelitian-rev', PenelitianController::class);
    Route::resource('ppm/pengabdian-rev', PengabdianController::class);
    Route::get('ppm/penelitian-rev/{id}/review', [PenelitianController::class, 'review'])->name('penelitian-rev.review');
    Route::post('ppm/penelitian-rev/{id}/submitReview', [PenelitianController::class, 'submitReview'])->name('penelitian-rev.submitReview');
    Route::get('ppm/pengabdian-rev/{id}/review', [PengabdianController::class, 'review'])->name('pengabdian-rev.review');
    Route::post('ppm/pengabdian-rev/{id}/submitReview', [PengabdianController::class, 'submitReview'])->name('pengabdian-rev.submitReview');
    Route::put('/penelitian/review/{id}', [PenelitianController::class, 'updateReview'])->name('penelitian-rev.updateReview');
    Route::put('/pengabdian/review/{id}', [PengabdianController::class, 'updateReview'])->name('pengabdian-rev.updateReview');
    Route::get('ppm/pengabdian-rev/{id}/editReview', [PengabdianController::class, 'editReview'])->name('pengabdian-rev.editReview');
    Route::get('ppm/penelitian-rev/{id}/editReview', [PenelitianController::class, 'editReview'])->name('penelitian-rev.editReview');
    Route::get('ppm/penelitian-rev/{id}/view/pdf', [PenelitianController::class, 'view_pdf'])->name('penelitian-rev.view_pdf');
    Route::get('/penelitian-rev/{id}/view-pdf', [PenelitianController::class, 'view_pdf'])->name('penelitian-rev.view_pdf');

    Route::get('ppm/pengabdian-rev/{id}/view/pdf', [PengabdianController::class, 'view_pdf'])->name('pengabdian-rev.view_pdf');
    Route::get('/pengabdian-rev/{id}/view-pdf', [PengabdianController::class, 'view_pdf'])->name('pengabdian-rev.view_pdf');

    Route::post('/penelitian/store', [PenelitianController::class, 'store'])->name('penelitian.store');
    Route::post('/pengabdian/store', [PengabdianController::class, 'store'])->name('pengabdian.store');

    Route::get('ppm/penelitian-rev/revisi/proposal', [PenelitianController::class, 'revisiIndex'])
        ->name('penelitian-rev.revisi.index');
    Route::get('ppm/pengabdian-rev/revisi/proposal', [PengabdianController::class, 'revisiIndex'])
        ->name('pengabdian-rev.revisi.index');

    // Form khusus review hasil revisi (ACC/Tolak + komentar)
    Route::get('ppm/penelitian-rev/revisi/{id}/review', [PenelitianController::class, 'revisiReview'])
        ->name('penelitian-rev.revisi.review');
    Route::post('ppm/penelitian-rev/revisi/{id}/submit', [PenelitianController::class, 'revisiReviewStore'])
        ->name('penelitian-rev.revisi.submit');

    Route::get('ppm/pengabdian-rev/revisi/{id}/review', [PengabdianController::class, 'revisiReview'])
        ->name('pengabdian-rev.revisi.review');
    Route::post('ppm/pengabdian-rev/revisi/{id}/submit', [PengabdianController::class, 'revisiReviewStore'])
        ->name('pengabdian-rev.revisi.submit');
});
