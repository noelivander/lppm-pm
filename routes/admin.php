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
use App\Http\Controllers\Admin\PPM\FokusBidangController;
use App\Http\Controllers\Admin\PPM\PenelitianController;
use App\Http\Controllers\Admin\PPM\PengabdianController;
use App\Http\Controllers\Admin\TimelineController;

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

    Route::resource('ppm/fokus-bidang', FokusBidangController::class);
    Route::resource('ppm/penelitian-adm', PenelitianController::class);
    Route::resource('ppm/pengabdian-adm', PengabdianController::class);
    Route::resource('ppm/pengaturan/luaran', LuaranController::class);
    Route::resource('ppm/pengaturan/skema', SkemaController::class);

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

    Route::get('/admin/timeline', [TimelineController::class, 'index'])->name('admin.timeline.index');
    Route::get('/admin/timeline/create', [TimelineController::class, 'create'])->name('admin.timeline.create');
    Route::post('/admin/timeline', [TimelineController::class, 'store'])->name('admin.timeline.store');

});
