@props(['breadcrumbs'=>[], 'judul'=>'', 'user'=>'', 'tanggal'=>'', 'link'=>'','link_text'=>'', 'waktu'=>'', 'tag'=>'', 'lokasi'=>''])

<div class="py-5 bg-primary hero-header mb-5">
    <div class="container my-5 py-5 px-lg-5">
        <div class="row">
            @if($breadcrumbs)  
                <div class="col-12">
                    <div class="text-center">
                        <h1 class="text-white animated zoomIn">{{$judul}}</h1>
                        <hr class="bg-white mx-auto mt-0" style="width: 90px;">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                @foreach($breadcrumbs as $list)
                                    <li class="breadcrumb-item"><a class="text-white" href="{{ route($list[1]) }}">{{ $list[0] }}</a></li>
                                @endforeach
                                <li class="breadcrumb-item text-white active" aria-current="page">{{$judul}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            @else
                <div class="col-md-7 pt-5">
                    <h3 class="text-white animated zoomIn">{{$judul}}</h3>
                    
                        <p class="text-white wow animated zoomIn" data-wow-delay="0.1s">
                            @if($user)
                            <i class="fa fa-user text-warning"></i> <span>{{$user}}</span>&ensp;&ensp;
                            @endif
                            @if($tag)
                            <i class="fa fa-tag text-warning"></i> <span>{{$tag}}</span>&ensp;&ensp;
                            @endif
                            @if($tanggal)
                            <i class="fa fa-calendar text-warning"></i> <span>{{$tanggal}}</span>
                            @endif
                            @if($waktu)
                            &ensp;&ensp;<i class="fa fa-clock text-warning"></i> <span>{{$tanggal}}</span>
                            @endif
                        </p>
                        @if($lokasi)
                            <p class="text-white wow animated zoomIn" data-wow-delay="0.1s">
                                <i class="fa fa-map-marker-alt text-warning"></i> <span>{{$lokasi}}</span>
                            </p>
                        @endif
                    
                    @if($link)
                        <a href="{{ $link }}" class="btn btn-secondary text-light rounded-pill py-2 px-4 wow animated slideInLeft" data-wow-delay="0.2s" target="_blank">{{$link_text}}</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>