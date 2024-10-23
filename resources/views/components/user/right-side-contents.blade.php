<div class="">
    <div class="card shadow wow animated zoomIn"  data-wow-delay="0.2s">
        <div class="card-body text-center">
            <h5 class="">Berita Terbaru</h5>
            <hr class="bg-primary mx-auto m-0" style="width: 90px;">
        </div>
        <ul class="list-group list-group-flush">
        @foreach($berita_terbaru as $list)
            <li class="list-group-item">
                <a href="{{ route('layanan-berita.show',['slug'=>$list->slug]) }}" class="text-decoration-none text-muted">
                    <strong>{{maxStr($list->judul,50)}}</strong><br>
                    <i class="fa fa-calendar text-warning"></i> <span class="fw-lighter">{{ $list->created_at->format('d F Y') }}</span>
                </a>
            </li>
        @endforeach
        </ul>
        <div class="card-body text-center">
            <a href="{{ route('layanan-berita.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Selengkapnya</a>
        </div>
    </div>
</div>
<div class="pt-4">
    <div class="card shadow wow animated zoomIn"  data-wow-delay="0.2s">
        <div class="card-body text-center">
            <h5 class="">Pengumuman Terbaru</h5>
            <hr class="bg-primary mx-auto m-0" style="width: 90px;">
        </div>
        <ul class="list-group list-group-flush">
        @foreach($pengumuman_terbaru as $list)
            <li class="list-group-item">
                <a href="{{ route('layanan-pengumuman.show',['slug'=>$list->slug]) }}" class="text-decoration-none text-muted">
                    <strong>{{maxStr($list->judul,50)}}</strong><br>
                    <i class="fa fa-calendar text-warning"></i> <span class="fw-lighter">{{ $list->created_at->format('d F Y') }}</span>
                </a>
            </li>
        @endforeach
        </ul>
        <div class="card-body text-center">
            <a href="{{ route('layanan-pengumuman.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Selengkapnya</a>
        </div>
    </div>
</div>

<div class="pt-4">
    <div class="card shadow wow animated zoomIn"  data-wow-delay="0.2s">
        <div class="card-body text-center">
            <h5 class="">Agenda Terbaru</h5>
            <hr class="bg-primary mx-auto m-0" style="width: 90px;">
        </div>
        <ul class="list-group list-group-flush">
        @foreach($agenda_terbaru as $list)
            <li class="list-group-item">
                <a href="{{ route('layanan-agenda.show',['slug'=>$list->slug]) }}" class="text-decoration-none text-muted">
                    <strong>{{maxStr($list->judul,50)}}</strong><br>
                    <i class="fa fa-calendar text-warning"></i>
                    @if($list->jadwal_akhir)
                        <span class="fw-lighter">{{ convertDatetileLocToDateShort($list->jadwal) }} - {{ convertDatetileLocToDateShort($list->jadwal_akhir) }}</span>
                    @else
                        <span class="fw-lighter">{{ convertDatetileLocToDate($list->jadwal) }}</span>
                    @endif
                </a>
            </li>
        @endforeach
        </ul>
        <div class="card-body text-center">
            <a href="{{ route('layanan-agenda.index') }}" class="btn btn-outline-secondary btn-sm">Lihat Selengkapnya</a>
        </div>
    </div>
</div>