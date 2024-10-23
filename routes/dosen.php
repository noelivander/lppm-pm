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
});
