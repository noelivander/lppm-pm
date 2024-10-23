<x-user-layout>
    <x-slot name="title">
        {{ __('Dokumen Penting') }}
    </x-slot>
    <x-user.header 
        :breadcrumbs="[['Home','home'],['Layanan','kelembagaan_struktur_organisasi']]"
        judul="Dokumen Penting">
    </x-user.header>

    <div class="container py-5">
        @if($dokumen_ppm->count()>0)
        <div class="row justify-content-md-center g-5 mb-5">
            <h3 class="text-center">Dokumen Penelitian dan Pengabdian kepada Masyarakat</h3>
            <div class="col-lg-9">
                <div class="row justify-content-center g-5">
                @foreach($dokumen_ppm as $key => $value)
                    <div class="col-lg-3 col-md-4 portfolio-item first wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$value->cover) }}" alt="">
                            <div class="portfolio-overlay">
                                @if($value->is_lock)
                                <a class="btn btn-light" href="{{ asset('storage/'.$value->cover) }}" data-lightbox="portfolio"><i class="fa fa-lock fa-2x text-primary"></i></a>
                                @else
                                <a class="btn btn-light" href="{{ route('dokumen.show',['slug'=>$value->slug]) }}"><i class="fa fa-search fa-2x text-primary"></i></a>
                                @endif
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Dokumen</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">{{ $value->judul }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($dokumen_pm->count()>0)
        <div class="row justify-content-md-center g-5 mb-5">
            <h3 class="text-center">Dokumen Penjaminan Mutu</h3>
            <div class="col-lg-9 ">
                <div class="row justify-content-center g-5">
                @foreach($dokumen_pm as $key => $value)
                    <div class="col-lg-3 col-md-4 portfolio-item first wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$value->cover) }}" alt="">
                            <div class="portfolio-overlay">
                                @if($value->is_lock)
                                <a class="btn btn-light" href="{{ asset('storage/'.$value->cover) }}" data-lightbox="portfolio"><i class="fa fa-lock fa-2x text-primary"></i></a>
                                @else
                                <a class="btn btn-light" href="{{ route('dokumen.show',['slug'=>$value->slug]) }}"><i class="fa fa-search fa-2x text-primary"></i></a>
                                @endif
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Dokumen</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">{{ $value->judul }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($dokumen_umum->count()>0)
        <div class="row justify-content-md-center g-5 mb-5">
            <h3 class="text-center">Dokumen Umum</h3>
            <div class="col-lg-9 ">
                <div class="row justify-content-center g-5">
                @foreach($dokumen_umum as $key => $value)
                    <div class="col-lg-3 col-md-4 portfolio-item first wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$value->cover) }}" alt="">
                            <div class="portfolio-overlay">
                                @if($value->is_lock)
                                <a class="btn btn-light" href="{{ asset('storage/'.$value->cover) }}" data-lightbox="portfolio"><i class="fa fa-lock fa-2x text-primary"></i></a>
                                @else
                                <a class="btn btn-light" href="{{ route('dokumen.show',['slug'=>$value->slug]) }}"><i class="fa fa-search fa-2x text-primary"></i></a>
                                @endif
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Dokumen</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">{{ $value->judul }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif


        @if($dokumen_lain->count()>0)
        <div class="row justify-content-md-center g-5 mb-5">
            <h3 class="text-center">Dokumen Lainnya</h3>
            <div class="col-lg-9 ">
                <div class="row justify-content-center g-5">
                @foreach($dokumen_lain as $key => $value)
                    <div class="col-lg-3 col-md-4 portfolio-item first wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$value->cover) }}" alt="">
                            <div class="portfolio-overlay">
                                @if($value->is_lock)
                                <a class="btn btn-light" href="{{ asset('storage/'.$value->cover) }}" data-lightbox="portfolio"><i class="fa fa-lock fa-2x text-primary"></i></a>
                                @else
                                <a class="btn btn-light" href="{{ route('dokumen.show',['slug'=>$value->slug]) }}"><i class="fa fa-search fa-2x text-primary"></i></a>
                                @endif
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Dokumen</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">{{ $value->judul }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</x-user-layout>