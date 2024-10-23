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
    Route::get('ppm/pengabdian-rev/{id}/review', [pengabdianController::class, 'review'])->name('pengabdian-rev.review');
    Route::post('ppm/pengabdian-rev/{id}/submitReview', [pengabdianController::class, 'submitReview'])->name('pengabdian-rev.submitReview');
    Route::put('/penelitian/review/{id}', [PenelitianController::class, 'updateReview'])->name('penelitian-rev.updateReview');
    Route::put('/pengabdian/review/{id}', [PengabdianController::class, 'updateReview'])->name('pengabdian-rev.updateReview');
    Route::get('ppm/pengabdian-rev/{id}/editReview', [PengabdianController::class, 'editReview'])->name('pengabdian-rev.editReview');
    Route::get('ppm/penelitian-rev/{id}/editReview', [PenelitianController::class, 'editReview'])->name('penelitian-rev.editReview');

});