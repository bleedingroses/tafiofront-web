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
                                <a href="{{ url('promo/' . $content->id) }}">{!! gambar($content->gambar_kecil) !!}</a>

                               
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








    <section id="produk-section">
        <div class="container">
        <div id="js-filters-agency" class="cbp-l-filters-text">
            <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">
                All <div class="cbp-filter-counter"></div>
            </div> |
           
           
            @foreach ($company->ambilMenu('produk')->kategori()->take(4)->get() as $kategori)

                <div data-filter=".{{ str_replace(' ', '-', $kategori->nama) }}" class="cbp-filter-item">
                    {{ $kategori->nama }} <div class="cbp-filter-counter"></div>
                </div>
            @endforeach
        </div>

        <div id="js-grid-agency" class="cbp cbp-l-grid-agency">
            @foreach ($company->ambilMenu('produk')->content as $content)
                <div class="cbp-item {{ str_replace(' ', '-',$content->judul) }}">
                   
                    <a href="#">
                        {{-- {{ route('produk', $content->judul) }} --}}
                        <div class="cbp-caption">
                            <div class="cbp-caption-defaultWrap">
                                {!! gambar($content->gambar_kecil) !!}
                            </div>
                        </div>
                        <div class="cbp-l-grid-agency-title">{!! $content->judul !!}</div>
                    </a>
                </div>
            @endforeach
        </div>
        </div>
    </section>




        {{-- <div class="container">
            <div class="row">
                <div class="gallery col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h1 class="gallery-title">Gallery</h1>
                </div>

                <div align="center">


                   
               
                    <div align="center">
                         @foreach ($company->ambilMenu('produk')->kategori()->take(4)->get() as $kategori)
                        <button class="btn btn-default filter-button" data-filter="all">{!! $kategori->nama !!}</button>
                        @endforeach
                    </div>
                </div>
                <br />


                @foreach ($company->ambilMenu('produk')->content as $content)
                    <div class="gallery_product col-lg-4 col-md-4 col-sm-4 col-xs-6 filter hdpe" width="50px" >
                        <div class="img-responsive">{!! gambar($content->gambar_kecil) !!}</div>                      
                        <p style="color:rgb(245, 14, 49);">  {!! $content->judul !!} </p>

                    </div>
                @endforeach
            </div>


        </div> --}}



    </section>

    @include($folder . 'partials.mengapa-kami')



@endsection



<style>
    .gallery-title {
        font-size: 36px;
        color: #42B32F;
        text-align: center;
        font-weight: 500;
        margin-bottom: 70px;
    }

    .gallery-title:after {
        content: "";
        position: absolute;
        width: 7.5%;
        left: 46.5%;
        height: 45px;
        border-bottom: 1px solid #5e5e5e;
    }

    .filter-button {
        font-size: 18px;
        border: 1px solid #42B32F;
        border-radius: 5px;
        text-align: center;
        color: #42B32F;
        margin-bottom: 30px;

    }

    .filter-button:hover {
        font-size: 18px;
        border: 1px solid #42B32F;
        border-radius: 5px;
        text-align: center;
        color: #ffffff;
        background-color: #42B32F;

    }

    .btn-default:active .filter-button:active {
        background-color: #42B32F;
        color: white;
    }

    .port-image {
        width: 100%;
    }

    .gallery_product {
        margin-bottom: 30px;
    }
</style>








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

