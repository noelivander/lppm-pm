<!-- Footer Start -->
<div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="row pb-4 g-2">
                    <div class="col-3">
                        <img src="{{ url('Logo.png') }}" alt="Logo"  class="d-inline-block img-fluid">      
                    </div>
                    <div class="col align-self-end">
                        <p class="align-bottom m-0">
                            <b class="h2 text-white">{{ __($project_name) }}</b><br>
                            <small>{{ __($institut_name) }}</small>
                        </p>
                    </div>
                </div>
                  
                </a>

                <dl class="row pt-4">
                    <dt class="col-1"><i class="fa fa-map-marker-alt me-3"></i></dt>
                    <dd class="col-11">
                        <p><b class="text-white">Kampus 1:</b> <span>Jl. Balai Kota No. 1 Parepare</span><br>
                            <b class="text-white">Kampus 2:</b> <span>Jl. Pemuda No. 6 Parepare</span></p>
                    </dd>

                    <dt class="col-1"><i class="fa fa-phone-alt me-3"></i></dt>
                    <dd class="col-11"><p>(0421) 2924000</p></dd>

                    <dt class="col-1"><i class="fa fa-envelope me-3"></i></dt>
                    <dd class="col-11"><p>{{ $project_email }}</p></dd>
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
                <h5 class="text-white mb-4">Tautan Terkait</h5>
                @foreach($related_links as $key => $link)
                    <a class="btn btn-link" href="{{ $link->url }}" target="_blank">{{ __($link->nama)}}</a>
                @endforeach
            </div>
            <div class="col-md-6 col-lg-4">
                <h5 class="text-white mb-4">Pengumuman Terbaru</h5>
                <div class="row g-2">
                    @foreach($pengumuman_terbaru as $list)
                    <div class="col-4">
                        <a href="{{ route('layanan-pengumuman.show',['slug'=>$list->slug]) }}">
                            <img class="img-fluid w-100" src="{{ asset('storage/'.$list->cover) }}" alt="">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">{{ __('2022 TIM LPPM-PM ITH') }}</a>, All Right Reserved. 
					
					<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
					Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                    <br>Distributed By: <a class="border-bottom" href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ route('home') }}">Beranda</a>
                        <a href="{{ route('dokumen.index') }}">Dokumen</a>
                        <!-- <a href="">Help</a>
                        <a href="">FQAs</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->