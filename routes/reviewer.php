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
    Route::resource('ppm/penelitian-rev', PenelitianController::class)->only(['index']);
    Route::resource('ppm/pengabdian-rev', PengabdianController::class)->only(['index']);
    Route::get('ppm/penelitian-rev/{id}/review', [PenelitianController::class, 'review'])->name('penelitian-rev.review');
    Route::post('ppm/penelitian-rev/{id}/submitReview', [PenelitianController::class, 'submitReview'])->name('penelitian-rev.submitReview');
    Route::get('ppm/pengabdian-rev/{id}/review', [PengabdianController::class, 'review'])->name('pengabdian-rev.review');
    Route::post('ppm/pengabdian-rev/{id}/submitReview', [PengabdianController::class, 'submitReview'])->name('pengabdian-rev.submitReview');
    Route::get('ppm/penelitian-rev/laporan-kemajuan', [PenelitianController::class, 'laporanKemajuanIndex'])->name('penelitian-rev.laporan-kemajuan.index');
    Route::get('ppm/pengabdian-rev/laporan-kemajuan', [PengabdianController::class, 'laporanKemajuanIndex'])->name('pengabdian-rev.laporan-kemajuan.index');
    Route::get('ppm/penelitian-rev/{penelitian}/laporan-kemajuan/create', [PenelitianController::class, 'laporanKemajuanCreate'])->name('penelitian-rev.laporan-kemajuan.create');
    Route::post('ppm/penelitian-rev/{penelitian}/laporan-kemajuan', [PenelitianController::class, 'laporanKemajuanStore'])->name('penelitian-rev.laporan-kemajuan.store');
    Route::get('ppm/penelitian-rev/{penelitian}/laporan-kemajuan/pdf', [PenelitianController::class, 'laporanKemajuanPdf'])->name('penelitian-rev.laporan-kemajuan.pdf');
    Route::get('ppm/pengabdian-rev/{pengabdian}/laporan-kemajuan/create', [PengabdianController::class, 'laporanKemajuanCreate'])->name('pengabdian-rev.laporan-kemajuan.create');
    Route::post('ppm/pengabdian-rev/{pengabdian}/laporan-kemajuan', [PengabdianController::class, 'laporanKemajuanStore'])->name('pengabdian-rev.laporan-kemajuan.store');
    Route::get('ppm/pengabdian-rev/{pengabdian}/laporan-kemajuan/pdf', [PengabdianController::class, 'laporanKemajuanPdf'])->name('pengabdian-rev.laporan-kemajuan.pdf');
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

    // Laporan Akhir Penelitian
    Route::get('ppm/penelitian-rev/laporan-akhir', [PenelitianController::class, 'laporanAkhirIndex'])->name('penelitian-rev.laporan-akhir.index');
    Route::get('ppm/penelitian-rev/{penelitian}/laporan-akhir/create', [PenelitianController::class, 'laporanAkhirCreate'])->name('penelitian-rev.laporan-akhir.create');
    Route::post('ppm/penelitian-rev/{penelitian}/laporan-akhir', [PenelitianController::class, 'laporanAkhirStore'])->name('penelitian-rev.laporan-akhir.store');
    Route::get('ppm/penelitian-rev/{penelitian}/laporan-akhir/pdf', [PenelitianController::class, 'laporanAkhirPdf'])->name('penelitian-rev.laporan-akhir.pdf');

    // Laporan Akhir Pengabdian
    Route::get('ppm/pengabdian-rev/laporan-akhir', [PengabdianController::class, 'laporanAkhirIndex'])->name('pengabdian-rev.laporan-akhir.index');
    Route::get('ppm/pengabdian-rev/{pengabdian}/laporan-akhir/create', [PengabdianController::class, 'laporanAkhirCreate'])->name('pengabdian-rev.laporan-akhir.create');
    Route::post('ppm/pengabdian-rev/{pengabdian}/laporan-akhir', [PengabdianController::class, 'laporanAkhirStore'])->name('pengabdian-rev.laporan-akhir.store');
    Route::get('ppm/pengabdian-rev/{pengabdian}/laporan-akhir/pdf', [PengabdianController::class, 'laporanAkhirPdf'])->name('pengabdian-rev.laporan-akhir.pdf');
});
