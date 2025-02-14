<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dosen\PPM\PenelitianController;
use App\Http\Controllers\Dosen\PPM\PengabdianController;

/*
|-------------------------------------------------------------------------- 
| Dosen Routes 
|-------------------------------------------------------------------------- 
| 
| These routes are specifically for dosen (lecturers). 
| They are protected by middleware to ensure only users with the "dosen" role 
| have access to them. 
| 
*/

Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::resource('ppm/penelitian-dos', PenelitianController::class);
    Route::resource('ppm/pengabdian-dos', PengabdianController::class);
    Route::get('penelitian/{penelitian_id}/view-reviews/{review_number}', [PenelitianController::class, 'viewReviews'])
     ->name('penelitian-dos.view-reviews');
     Route::get('pengabdian/{pengabdian_id}/view-reviews/{review_number}', [PengabdianController::class, 'viewReviews'])
     ->name('pengabdian-dos.view-reviews');
    Route::get('/penelitian/{id}/download-proposal', [PenelitianController::class, 'downloadDokumenProposal'])->name('penelitian.downloadProposal');
});
