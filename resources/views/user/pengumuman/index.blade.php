<x-user-layout>
    <x-user.header 
        :breadcrumbs="[['Home','home'],['Layanan','layanan-pengumuman.index']]"
        judul="Pengumuman">
    </x-user.header>

    <div class="container-xxl py-5">
        <div class="row justify-content-center g-5">
        @foreach($pengumuman as $key => $value)
            <!-- <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    <h5 class="mb-3">{{ maxStr($value->judul, 70) }}</h5>
                    <p>{{ maxStr($value->isi, 100) }}</p>

                    <a class="btn px-3 mt-auto mx-auto" href="{{ route('layanan-pengumuman.show',['slug'=>$value->slug]) }}">Read More</a>
                </div>
            </div> -->
            <div class="col-lg-3 col-md-4 col-xs-6 portfolio-item first wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                <div class="position-relative rounded overflow-hidden">
                    <img class="img-fluid w-100" src="{{ asset('storage/'.$value->cover) }}" alt="">
                    <div class="portfolio-overlay">
                        <a class="btn btn-light" href="{{ route('layanan-pengumuman.show',['slug'=>$value->slug]) }}"><i class="fa fa-search fa-2x text-primary"></i></a>
                        <div class="mt-auto">
                            <small class="text-white"><i class="fa fa-folder me-2"></i>Pengumuman</small>
                            <a class="h5 d-block text-white mt-1 mb-0" href="">{{ $value->judul }}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</x-user-layout>