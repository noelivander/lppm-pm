<x-user-layout>
    <x-slot name="title">
        {{ __('Agenda') }}
    </x-slot>
    <x-user.header 
        :breadcrumbs="[['Home','home'],['Layanan','layanan-agenda.index']]"
        judul="Agenda">
    </x-user.header>

    <div class="container-xxl py-5">
        <div class="row g-5">
        @foreach($agenda as $key => $value)
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="{{($key+1)*0.2}}s">
                <div class="service-item d-flex flex-column justify-content-center rounded">
                    <h5 class="mb-3 text-center">{{ $value->judul }}</h5>
                    <p>
                        @if($value->jadwal_akhir)
                            <i class="fa fa-calendar text-warning"></i> {{ convertDatetileLocToDateShort($value->jadwal) }} - {{ convertDatetileLocToDateShort($value->jadwal_akhir) }}
                        @else
                            <i class="fa fa-calendar text-warning"></i> {{ convertDatetileLocToDate($value->jadwal) }}<br>
                            <i class="fa fa-clock text-warning"></i> {{ convertDatetileLocToTime($value->jadwal) }}
                        @endif
                    </p>
                    @if($value->tag)
                        <p><i class="fa fa-tag text-warning"></i> {{ $value->tag }}</p>
                    @endif
                    @if($value->lokasi)
                        <p><i class="fa fa-map-marker-alt text-warning"></i> {{ $value->lokasi }}</p>
                    @endif
                    <a class="btn px-3 mt-auto mx-auto" href="{{ route('layanan-agenda.show',['slug'=>$value->slug]) }}">Read More</a>
                </div>
            </div>
        @endforeach
        </div>
    </div>
</x-user-layout>