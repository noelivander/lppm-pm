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
    Route::get('ppm/penelitian-dos/revisi/proposal', [PenelitianController::class, 'revisiIndex'])
        ->name('penelitian-dos.revisi.index');
    Route::get('ppm/pengabdian-dos/revisi/proposal', [PengabdianController::class, 'revisiIndex'])
        ->name('pengabdian-dos.revisi.index');

    // New Route: Riwayat Pendanaan
    Route::get('riwayat-pendanaan', [\App\Http\Controllers\DosenController::class, 'riwayatPendanaan'])
        ->name('dosen.riwayat-pendanaan');

    Route::get('ppm/penelitian-dos/laporan-kemajuan/proposal', [PenelitianController::class, 'laporanKemajuanIndex'])
        ->name('penelitian-dos.laporan-kemajuan.index');
    Route::get('ppm/pengabdian-dos/laporan-kemajuan/proposal', [PengabdianController::class, 'laporanKemajuanIndex'])
        ->name('pengabdian-dos.laporan-kemajuan.index');
    Route::get('ppm/penelitian-dos/laporan-akhir/proposal', [PenelitianController::class, 'laporanAkhirIndex'])
        ->name('penelitian-dos.laporan-akhir.index');
    Route::get('ppm/pengabdian-dos/laporan-akhir/proposal', [PengabdianController::class, 'laporanAkhirIndex'])
        ->name('pengabdian-dos.laporan-akhir.index');
    Route::get('ppm/penelitian-dos/{penelitian}/laporan-kemajuan/create', [PenelitianController::class, 'createLaporanKemajuan'])
        ->name('penelitian-dos.laporan-kemajuan.create');
    Route::post('ppm/penelitian-dos/{penelitian}/laporan-kemajuan/store', [PenelitianController::class, 'storeLaporanKemajuan'])
        ->name('penelitian-dos.laporan-kemajuan.store');
    Route::get('ppm/pengabdian-dos/{pengabdian}/laporan-kemajuan/create', [PengabdianController::class, 'createLaporanKemajuan'])
        ->name('pengabdian-dos.laporan-kemajuan.create');
    Route::post('ppm/pengabdian-dos/{pengabdian}/laporan-kemajuan/store', [PengabdianController::class, 'storeLaporanKemajuan'])
        ->name('pengabdian-dos.laporan-kemajuan.store');

    Route::get('ppm/penelitian-dos/{penelitian}/laporan-akhir/create', [PenelitianController::class, 'createLaporanAkhir'])
        ->name('penelitian-dos.laporan-akhir.create');
    Route::post('ppm/penelitian-dos/{penelitian}/laporan-akhir/store', [PenelitianController::class, 'storeLaporanAkhir'])
        ->name('penelitian-dos.laporan-akhir.store');
    Route::get('ppm/pengabdian-dos/{pengabdian}/laporan-akhir/create', [PengabdianController::class, 'createLaporanAkhir'])
        ->name('pengabdian-dos.laporan-akhir.create');
    Route::post('ppm/pengabdian-dos/{pengabdian}/laporan-akhir/store', [PengabdianController::class, 'storeLaporanAkhir'])
        ->name('pengabdian-dos.laporan-akhir.store');
    Route::get('ppm/penelitian-dos/{penelitian}/revisi', [PenelitianController::class, 'revisiCreate'])
        ->name('penelitian-dos.revisi.create');
    Route::post('ppm/penelitian-dos/{penelitian}/revisi', [PenelitianController::class, 'revisiStore'])
        ->name('penelitian-dos.revisi.store');
    Route::get('ppm/pengabdian-dos/{pengabdian}/revisi', [PengabdianController::class, 'revisiCreate'])
        ->name('pengabdian-dos.revisi.create');
    Route::post('ppm/pengabdian-dos/{pengabdian}/revisi', [PengabdianController::class, 'revisiStore'])
        ->name('pengabdian-dos.revisi.store');

    Route::resource('ppm/penelitian-dos', PenelitianController::class);
    Route::resource('ppm/pengabdian-dos', PengabdianController::class);
    Route::get('penelitian/{penelitian_id}/view-reviews/{review_number}', [PenelitianController::class, 'viewReviews'])
        ->name('penelitian-dos.view-reviews');
    Route::get('pengabdian/{pengabdian_id}/view-reviews/{review_number}', [PengabdianController::class, 'viewReviews'])
        ->name('pengabdian-dos.view-reviews');
    Route::get('pengabdian/{pengabdian_id}/laporan-kemajuan/view-reviews', [PengabdianController::class, 'viewLaporanKemajuanReviews'])
        ->name('pengabdian-dos.laporan-kemajuan.view-reviews');
    Route::get('penelitian/{penelitian_id}/laporan-kemajuan/view-reviews/{review_number}', [PenelitianController::class, 'viewLaporanKemajuanReviews'])
        ->name('penelitian-dos.laporan-kemajuan.view-reviews');
    Route::get('penelitian/{penelitian_id}/laporan-akhir/view-reviews/{review_number}', [PenelitianController::class, 'viewLaporanAkhirReviews'])
        ->name('penelitian-dos.laporan-akhir.view-reviews');
    Route::get('pengabdian/{pengabdian_id}/laporan-akhir/view-reviews', [PengabdianController::class, 'viewLaporanAkhirReviews'])
        ->name('pengabdian-dos.laporan-akhir.view-reviews');
    Route::get('/penelitian/{id}/download-proposal', [PenelitianController::class, 'downloadDokumenProposal'])->name('penelitian.downloadProposal');
    Route::get('/pengabdian/{id}/download-proposal', [PengabdianController::class, 'downloadDokumenProposal'])->name('pengabdian.downloadProposal');

    // RAB Helper routes for dynamic satuan
    Route::get('rab/get-satuan-by-komponen', [\App\Http\Controllers\Dosen\PPM\RabHelperController::class, 'getSatuanByKomponenName'])
        ->name('dosen.rab.get-satuan-by-komponen');
});
