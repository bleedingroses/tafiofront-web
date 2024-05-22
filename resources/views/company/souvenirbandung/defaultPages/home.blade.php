@extends($folder . 'layouts.main')

@section('main')
    <section class="wrapper bg-dark">
        <div class="swiper-container swiper-thumbs-container swiper-fullscreen nav-dark" data-margin="0" data-autoplay="true"
            data-autoplaytime="7000" data-nav="true" data-dots="false" data-items="1" data-thumbs="true">
            <div class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($company->ambilMenu('slider')->content as $content)
                        <div class="swiper-slide bg-image"
                            data-image-src="{{ 'http://' . env('BACKEND') . '/storage/content/' . substr($content->gambar_besar, 0, 2) . '/' . substr($content->gambar_besar, 2, 2) . '/' . $content->gambar_besar }}">
                        </div>
                    @endforeach
                </div>
                <!--/.swiper-wrapper -->
            </div>
            <!-- /.swiper -->
            <div class="swiper swiper-thumbs">
                <div class="swiper-wrapper">
                    @foreach ($company->ambilMenu('slider')->content as $content)
                        <div class="swiper-slide">{!! gambar($content->gambar_kecil) !!}</div>
                    @endforeach
                </div>
                <!--/.swiper-wrapper -->
            </div>
            <!-- /.swiper -->
            <div class="swiper-static">
                <div class="container h-100 d-flex align-items-center justify-content-center">
                    <div class="row">
                        <div class="col-lg-10 col-md-8 mx-auto mt-n10 text-center">
                            <h1 class="text-uppercase ls-xl mb-3 animate__animated animate__zoomIn animate__delay-1s">
                                <span class="tagline">solusi cetakmu</span>
                            </h1>
                            <h2 class="fs-40 animate__animated animate__zoomIn animate__delay-2s"><span
                                    class="ityped"></span> </h2>
                            <h3 class="mb-0 animate__animated animate__zoomIn animate__delay-3s">Yang tidak
                                sempat desain. Tidak mau macet atau antri. Serta butuh kepastian harga.</h3>
                        </div>
                        <!-- /column -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container -->
            </div>
            <!-- /.swiper-static -->
        </div>
        <!-- /.swiper-container -->
    </section>
    <!-- /section -->

    <section class="wrapper">
        <div class="container pt-5 pb-5 pt-md-10 pb-md-10">
            <div class="swiper-container dots-over" data-margin="5" data-dots="true" data-nav="true" data-autoheight="true">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($company->ambilMenu('promo')->content as $content)
                        <div class="swiper-slide rounded">
                            <a href="{{ url('promo/'.$content->id) }}">{!! gambar($content->gambar_besar) !!}</a>
                        </div>
                        @endforeach
                        <!--/.swiper-slide -->
                    </div>
                    <!--/.swiper-wrapper -->
                </div>
                <!-- /.swiper -->
            </div>
            <!-- /.swiper-container -->
        </div>
    </section>
@endsection

@push('addons-style')
    <style>
        .tagline {
            font-family: "Permanent Marker", cursive;
            font-size: 50px;
            color: #00b5f0;
        }
    </style>
@endpush

@push('addons-script')
    <script src="https://unpkg.com/ityped@0.0.10"></script>
    <script>
        window.ityped.init(document.querySelector('.ityped'), {
            strings: ['Advertising', 'Souvenir'],
            loop: true,
            backDelay: 3000,
        });
    </script>
@endpush
