<!-- Footer Start -->
    <div class="container-fluid footer mt-5 pt-4 wow fadeIn" data-wow-delay="0.1s" style="background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #7c3aed 100%);">
    <div class="container py-4 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="row pb-4 g-2">
                    <div class="col-3">
                        <img src="{{ url('Logo.png') }}" alt="Logo"  class="d-inline-block img-fluid">      
                    </div>
                    <div class="col align-self-end">
                        <p class="align-bottom m-0">
                            <b class="h2 text-white">{{ __($project_name) }}</b><br>
                            <small class="text-white">{{ __($institut_name) }}</small>
                        </p>
                    </div>
                </div>
                  
                </a>

                <dl class="row pt-4">
                    <dt class="col-1"><i class="fa fa-map-marker-alt me-3 text-white"></i></dt>
                    <dd class="col-11">
                        <p><b class="text-white">Kampus 1:</b> <span class="text-white"> Jl. Balai Kota No. 1 Parepare</span><br>
                            <b class="text-white">Kampus 2:</b> <span class="text-white"> Jl. Pemuda No. 6 Parepare</span></p>
                    </dd>

                    <dt class="col-1"><i class="fa fa-phone-alt me-3 text-white"></i></dt>
                    <dd class="col-11"><p class="text-white">(0421) 2924000</p></dd>

                    <dt class="col-1"><i class="fa fa-envelope me-3 text-white"></i></dt>
                    <dd class="col-11"><p class="text-white">{{ $project_email }}</p></dd>
                </dl>

                <div class="d-flex">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xl-4">
                <h5 class="text-white mb-4">Layanan</h5>
                <div class="d-flex flex-column">
                    <a class="text-white-75 mb-2" href="{{ route('layanan-agenda.index') }}"><i class="fa fa-angle-right me-2"></i>Agenda Kegiatan</a>
                    <a class="text-white-75 mb-2" href="{{ route('layanan-pengumuman.index') }}"><i class="fa fa-angle-right me-2"></i>Pengumuman</a>
                    <a class="text-white-75 mb-2" href="{{ route('dokumen.index') }}"><i class="fa fa-angle-right me-2"></i>Dokumen Publik</a>
                    <a class="text-white-75 mb-2" href="{{ route('layanan-berita.index') }}"><i class="fa fa-angle-right me-2"></i>Berita</a>
                    <a class="text-white-75 mb-2" href="{{ route('kelembagaan_tentang') }}"><i class="fa fa-angle-right me-2"></i>Tentang Kami</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <h5 class="text-white mb-3">Tautan Terkait</h5>
                <div class="d-flex flex-column">
                    @foreach($related_links as $key => $link)
                        <a class="text-white-75 mb-2" href="{{ $link->url }}" target="_blank"><i class="fa fa-angle-right me-2"></i>{{ __($link->nama)}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    &copy; <a class="border-bottom text-white-50" href="#">{{ __('2024 TIM LPPM-PM ITH') }}</a>, All Right Reserved. 
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->