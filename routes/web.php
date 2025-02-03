<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AgendaController;
use App\Http\Controllers\User\BeritaController;
use App\Http\Controllers\User\DokumenController;
use App\Http\Controllers\User\PenelitianController;
use App\Http\Controllers\User\PengabdianController;
use App\Http\Controllers\User\PengumumanController;
use App\Http\Controllers\User\BidangFokusController;
use App\Http\Controllers\User\KelembagaanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\AuditorController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\Admin\TimelineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/foo', function () {
   Artisan::call('storage:link');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('bidang-fokus/{slug}', [BidangFokusController::class, 'show'])->name('bidang-fokus.show');
Route::get('layanan-agenda', [AgendaController::class, 'index'])->name('layanan-agenda.index');
Route::get('layanan-agenda/{slug}', [AgendaController::class, 'show'])->name('layanan-agenda.show');
Route::get('layanan-berita', [BeritaController::class, 'index'])->name('layanan-berita.index');
Route::get('layanan-berita/{slug}', [BeritaController::class, 'show'])->name('layanan-berita.show');
Route::get('layanan-pengumuman', [PengumumanController::class, 'index'])->name('layanan-pengumuman.index');
Route::get('layanan-pengumuman/{slug}', [PengumumanController::class, 'show'])->name('layanan-pengumuman.show');

Route::get('dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
Route::get('dokumen/{slug}', [DokumenController::class, 'show'])->name('dokumen.show');

Route::get('penelitian', [PenelitianController::class, 'index'])->name('penelitian.index');
Route::get('pengabdian', [PengabdianController::class, 'index'])->name('pengabdian.index');

Route::get('/kelembagaan/tentang', [KelembagaanController::class, 'tentang'])->name('kelembagaan_tentang');
Route::get('/kelembagaan/struktur_organisasi', [KelembagaanController::class, 'struktur_organisasi'])->name('kelembagaan_struktur_organisasi');
Route::get('/kelembagaan/visi_misi', [KelembagaanController::class, 'visi_misi'])->name('kelembagaan_visi_misi');

Route::view('/lppm', 'lppm.index')->name('lppm');
Route::view('/lppm/penelitian', 'lppm.penelitian')->name('lppm_penelitian');
Route::view('/lppm/pengabdian', 'lppm.pengabdian')->name('lppm_pengabdian');
Route::view('/lppm/kkn', 'lppm.kkn')->name('lppm_kkn');
Route::view('/lppm/publikasi', 'lppm.publikasi')->name('lppm_publikasi');

Route::view('/lpmu', 'lpmu.index')->name('lpmu');

Route::view('/pengumuman', 'pengumuman')->name('pengumuman');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::prefix('admin')->group(function () {
    Route::resource('timeline', TimelineController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('timeline', TimelineController::class)->except(['show']);
});


Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
    Route::resource('dosen/ppm/penelitian-dos', PenelitianController::class);
    Route::resource('dosen/ppm/pengabdian-dos', PengabdianController::class);
});

Route::middleware(['auth', 'role:reviewer'])->group(function () {
    Route::get('/reviewer/dashboard', [ReviewerController::class, 'dashboard'])->name('reviewer.dashboard');
    Route::resource('reviewer/ppm/penelitian-rev', PenelitianController::class);
    Route::resource('reviewer/ppm/pengabdian-rev', PengabdianController::class);
});

Route::middleware(['auth', 'role:auditor'])->group(function () {
    Route::get('/auditor/dashboard', [AuditorController::class, 'dashboard'])->name('auditor.dashboard');
});

Route::middleware(['auth', 'role:kaprodi'])->group(function () {
    Route::get('/kaprodi/dashboard', [KaprodiController::class, 'dashboard'])->name('kaprodi.dashboard');
});

require __DIR__.'/auth.php';




/*
|
| Admin Routes
|
*/
