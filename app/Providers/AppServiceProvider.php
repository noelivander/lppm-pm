<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

use App\Models\RelatedLink;
use App\Models\PPM\FokusBidang;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Makassar');

        // Using view composer to set following variables globally
        view()->composer('*',function($view) {
            $view->with('related_links', RelatedLink::all());
            $view->with('daftar_fokus_bidang', FokusBidang::menu()->get());
            $view->with('agenda_terbaru', Agenda::terbaru()->get());
            $view->with('berita_terbaru', Berita::terbaru()->get());
            $view->with('pengumuman_terbaru', Pengumuman::terbaru()->get());
            $view->with('project_name', 'LPPM-PM');
            $view->with('project_email', 'lppm-pm@ith.ac.id');
            $view->with('institut_name', 'Institut Teknologi B.J. Habibie');
        });
    }

}

