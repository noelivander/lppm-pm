<x-user-layout>
    <div class="py-5 bg-primary hero-header mb-5">
        <div class="container my-5 py-5 px-lg-5">
            <div class="row g-5 pt-5 justify-content-between">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-5 text-white mb-4 animated zoomIn">LPPM-PM</h1>
                    <p class="text-white pb-3 lead animated zoomIn">Website resmi Lembaga Penelitian, Pengabdian kepada Masyarakat, dan Penjaminan Mutu (LPPM-PM)<br><b>{{__($institut_name)}}</b></p>
                    <a href="{{ route('kelembagaan_tentang') }}" class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Tentang Kami</a>
                    <!-- <a href="" class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Contact Us</a> -->
                </div>
                <div class="col-lg-5 text-center text-lg-start">
                    <img class="img-fluid" src="{{ asset('storage/home/section1/collecting.png') }}" alt="" width="75%">
                </div>
            </div>
        </div>
    </div>

    <!-- Full Screen Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);">
                <div class="modal-header border-0">
                    <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center justify-content-center">
                    <div class="input-group" style="max-width: 600px;">
                        <input type="text" class="form-control bg-transparent border-light p-3" placeholder="Type search keyword">
                        <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Full Screen Search End -->


    <!-- About Start -->
    <div class="py-5">
        <div class="container px-lg-5">
            <div class="row g-5 justify-content-between">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="section-title position-relative mb-4 pb-2">
                        <h6 class="position-relative text-primary ps-4">Yuk Kenalan</h6>
                        <h2 class="mt-2">Institut Teknologi Bacharuddin Jusuf Habibie (ITH)</h2>
                    </div>
                    <p class="mb-4">adalah Perguruan Tinggi Negeri di bawah naungan Kementerian Pendidikan, Kebudayaan, Riset dan Teknologi Republik Indonesia berdasarkan Peraturan Presiden Nomor 152 Tahun 2014, tanggal 17 Oktober 2014 yang ditandatangani oleh Presiden  H. Susilo Bambang Yudoyono. Dengan diterbitkannya Organisasi dan Tata Kerja melalui Peraturan Menteri Menteri Pendidikan, Kebudayaan, Riset dan Teknologi Republik Indonesia, Nomor 21 Tahun 2021 pada tanggal 4 Agustus 2021. Maka secara resmi Institut Teknologi B.J. Habibie mulai beroperasi.</p>
                    <!-- <div class="row g-3">
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>Award Winning</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Professional Staff</h6>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-3"><i class="fa fa-check text-primary me-2"></i>24/7 Support</h6>
                            <h6 class="mb-0"><i class="fa fa-check text-primary me-2"></i>Fair Prices</h6>
                        </div>
                    </div> -->
                    <div class="d-flex align-items-center mt-4">
                        <a class="btn btn-primary rounded-pill px-4 me-3" href="">Lebih Lengkap</a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square me-3" href=""><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-primary btn-square" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="{{ asset('vendor/user/img/research.png') }}">
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Newsletter Start -->
    <div class="bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container px-lg-5">
            <div class="row align-items-center" style="height: 250px;">
                <div class="col-12 col-md-6">
                    <h3 class="text-white">Cari tahu lebih detail</h3>
                    <small class="text-white">Kami menyediakan layanan untuk memudahkan kamu dalam pelaksanaan penelitian dan pengabdian kepada masyarakat.</small>
                    <div class="position-relative w-100 mt-3">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Tinggalkan Email Kamu Di Sini" style="height: 48px;">
                        <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i></button>
                    </div>
                </div>
                <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                    <img class="img-fluid mt-5" style="height: 250px;" src="{{ asset('vendor/user/img/newsletter.png') }}">
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->

    <!-- Service Start -->
    <div class="py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Layanan Kami</h6>
                <h2 class="mt-2">Berita Terbaru</h2>
            </div>
            <div class="row g-4">
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
                            <h5 class="mb-3">{{ maxStr($value->judul, 55) }}</h5>
                            @if(!$value->cover)
                            <p>{{ maxStr($value->isi, 70) }}</p>
                            @endif

                            <a class="btn px-3 mt-auto mx-auto" href="{{ route('layanan-berita.show',['slug'=>$value->slug]) }}">Read More</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Service End -->
</x-user-layout>