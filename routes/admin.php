<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\DokumenPentingController;
use App\Http\Controllers\Admin\Kelembagaan\StrukturorgController;
use App\Http\Controllers\Admin\Kelembagaan\TentangController;
use App\Http\Controllers\Admin\Kelembagaan\VisimisiController;
use App\Http\Controllers\Admin\Pengaturan\JurusanController;
use App\Http\Controllers\Admin\Pengaturan\ProgramStudiController;
use App\Http\Controllers\Admin\Pengaturan\RelatedLinkController;
use App\Http\Controllers\Admin\PPM\Pengaturan\LuaranController;
use App\Http\Controllers\Admin\PPM\Pengaturan\SkemaController;
use App\Http\Controllers\Admin\PPM\Pengaturan\RabController;
use App\Http\Controllers\Admin\PPM\FokusBidangController;
use App\Http\Controllers\Admin\PPM\PenelitianController;
use App\Http\Controllers\Admin\PPM\PengabdianController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\UserController;

/*
|-------------------------------------------------------------------------- 
| Admin Routes 
|-------------------------------------------------------------------------- 
| 
| These routes are specifically for admin users. 
| They are protected by middleware to ensure only users with the "admin" role 
| have access to them. 
| 
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('agenda', AgendaController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('pengumuman', PengumumanController::class);
    Route::resource('dokumen_penting', DokumenPentingController::class);
    Route::resource('users', UserController::class);

    Route::resource('ppm/fokus-bidang', FokusBidangController::class);
    Route::resource('ppm/penelitian-adm', PenelitianController::class);
    Route::resource('ppm/pengabdian-adm', PengabdianController::class);
    
    // Skema routes
    Route::get('skema', [SkemaController::class, 'index'])->name('skema.index');
    Route::post('skema', [SkemaController::class, 'store'])->name('skema.store');
    Route::get('skema/{skema}/edit', [SkemaController::class, 'edit'])->name('skema.edit');
    Route::put('skema/{skema}', [SkemaController::class, 'update'])->name('skema.update');
    Route::delete('skema/{skema}', [SkemaController::class, 'destroy'])->name('skema.destroy');
    
    // Luaran routes
    Route::get('luaran', [LuaranController::class, 'index'])->name('luaran.index');
    Route::post('luaran', [LuaranController::class, 'store'])->name('luaran.store');
    Route::get('luaran/{luaran}/edit', [LuaranController::class, 'edit'])->name('luaran.edit');
    Route::put('luaran/{luaran}', [LuaranController::class, 'update'])->name('luaran.update');
    Route::delete('luaran/{luaran}', [LuaranController::class, 'destroy'])->name('luaran.destroy');
    
    // RAB routes
    Route::get('rab', [RabController::class, 'index'])->name('rab.index');
    
    // Kelompok RAB routes
    Route::post('rab/kelompok', [RabController::class, 'storeKelompok'])->name('rab.store.kelompok');
    Route::get('rab/kelompok/{id}/edit', [RabController::class, 'editKelompok'])->name('rab.edit.kelompok');
    Route::put('rab/kelompok/{id}', [RabController::class, 'updateKelompok'])->name('rab.update.kelompok');
    Route::delete('rab/kelompok/{id}', [RabController::class, 'destroyKelompok'])->name('rab.destroy.kelompok');
    
    // Komponen RAB routes
    Route::post('rab/komponen', [RabController::class, 'storeKomponen'])->name('rab.store.komponen');
    Route::get('rab/komponen/{id}/edit', [RabController::class, 'editKomponen'])->name('rab.edit.komponen');
    Route::put('rab/komponen/{id}', [RabController::class, 'updateKomponen'])->name('rab.update.komponen');
    Route::delete('rab/komponen/{id}', [RabController::class, 'destroyKomponen'])->name('rab.destroy.komponen');
    
    // Satuan RAB routes
    Route::post('rab/satuan', [RabController::class, 'storeSatuan'])->name('rab.store.satuan');
    Route::get('rab/satuan/{id}/edit', [RabController::class, 'editSatuan'])->name('rab.edit.satuan');
    Route::put('rab/satuan/{id}', [RabController::class, 'updateSatuan'])->name('rab.update.satuan');
    Route::delete('rab/satuan/{id}', [RabController::class, 'destroySatuan'])->name('rab.destroy.satuan');
    
    // Komponen-Satuan assignment routes
    Route::get('rab/komponen/{id}/satuan', [RabController::class, 'getSatuanForKomponen'])->name('rab.komponen.satuan');
    Route::post('rab/komponen/{id}/assign-satuan', [RabController::class, 'assignSatuanToKomponen'])->name('rab.assign.satuan');

    Route::resource('kelembagaan/struktur-organisasi', StrukturorgController::class)->only([
        'index', 'store'
    ]);

    Route::resource('kelembagaan/tentang-satker', TentangController::class)->only([
        'index', 'store'
    ]);

    Route::resource('kelembagaan/visi-misi', VisimisiController::class)->only([
        'index', 'store'
    ]);

    Route::resource('pengatur/jurusan', JurusanController::class);
    Route::resource('pengatur/program_studi', ProgramStudiController::class);
    Route::resource('pengatur/related_link', RelatedLinkController::class);

    Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])->name('ckeditor.upload');

    // Timeline Management Routes
    Route::get('timeline', [TimelineController::class, 'index'])->name('timeline.index');
    Route::get('timeline/create', [TimelineController::class, 'create'])->name('timeline.create');
    Route::post('timeline', [TimelineController::class, 'store'])->name('timeline.store');
    Route::get('timeline/{id}/edit', [TimelineController::class, 'edit'])->name('timeline.edit');
    Route::put('timeline/{id}', [TimelineController::class, 'update'])->name('timeline.update');
    Route::delete('timeline/{id}', [TimelineController::class, 'destroy'])->name('timeline.destroy');
    Route::post('timeline/{id}/toggle-active', [TimelineController::class, 'toggleActive'])->name('timeline.toggleActive');

});
