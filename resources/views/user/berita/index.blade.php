<x-user-layout>
    <x-user.header 
        :breadcrumbs="[['Home','home'],['Layanan','layanan-berita.index']]"
        judul="Berita">
    </x-user.header>

    <div class="container-xxl py-5">
        <div class="row g-5">
        @foreach($berita as $key => $value)
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                    @if($value->cover)
                    <div class="berita-cover-list rounded">
                        <img src="{{ asset('storage/'.$value->cover) }}" class="img-fluid">
                    </div>
                    @else
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-newspaper fa-2x"></i>
                        </div>
                    @endif
                    <h5 class="mb-3">{{ maxStr($value->judul, 65) }}</h5>
                    @if(!$value->cover)
                    <p>{{ maxStr($value->isi, 70) }}</p>
                    @endif
                    <a class="btn px-3 mt-auto mx-auto" href="{{ route('layanan-berita.show',['slug'=>$value->slug]) }}">Baca Selanjutnya</a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</x-user-layout>