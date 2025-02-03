<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auditor\AmiController;

/*
|-------------------------------------------------------------------------- 
| Auditor Routes 
|-------------------------------------------------------------------------- 
| 
| These routes are specifically for Auditor (lecturers). 
| They are protected by middleware to ensure only users with the "Auditor" role 
| have access to them. 
| 
*/

Route::middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::resource('ami', AmiController::class);
    Route::get('/si', [AmiController::class, 'index'])->name('si.index');
    Route::get('/ik', [AmiController::class, 'index'])->name('ik.index');
    Route::get('/mtk', [AmiController::class, 'index'])->name('mtk.index');
    Route::post('/ami/submit', [AmiController::class, 'submit'])->name('ami.submit');
});
