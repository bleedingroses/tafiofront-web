<header class="wrapper bg-soft-primary">
    <nav class="navbar navbar-expand-lg classic transparent navbar-light">
        <div class="container flex-lg-row flex-nowrap align-items-center">
            <div class="navbar-brand w-100">
                @php
                    if (!empty($config)) {
                        $words = explode(' ', $config['logo']);
                        $word = implode(' ', array_splice($words, 0, 5));
                        $link = 'storage/web/' . $word[0] . $word[1] . '/' . $word[2] . $word[3] . '/';
                    }
                @endphp
                <a href="./index.html">
                    <img src="{{ !empty($config) ? url($link . $config['logo']) : '' }}" alt="" />
                </a>
            </div>
            <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                <div class="offcanvas-header d-lg-none">
                    <a href="./index.html"><img src="{{ asset($company->name . '/img/logo-light.png') }}"
                            srcset="{{ asset($company->name . '/img/logo-light@2x.png') }} 2x" alt="" /></a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                    <ul class="navbar-nav">
                                <li class="nav-item"><a class="nav-link" href="{!! url('kontak') !!}">kontak</a></li>
                                <li class="nav-item"><a class="nav-link" href="{!! url('about us') !!}">about us</a></li>
                      
                                <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#"
                                        data-bs-toggle="dropdown">marketplace</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($company->ambilMenu('marketplace')->content as $content)
                                            <li class="nav-item"><a class="dropdown-item" target="_blank"
                                                    href="{!! url($content->isi) !!}">{{ $content->judul }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                      
                        
                                <li class="nav-item dropdown dropdown-mega"><a class="nav-link dropdown-toggle"
                                        href="#" data-bs-toggle="dropdown">produk</a>
                                    <ul class="dropdown-menu mega-menu">
                                        <li class="mega-menu-content">
                                            <div class="row gx-0 gx-lg-3">
                                                @foreach ($company->ambilMenu('produk')->kategori()->take(4)->get() as $kategori)
                                                    <div class="col-lg-3">
                                                        <h6 class="dropdown-header">{{ $kategori->nama }}</h6>
                                                        <div class="row gx-0">
                                                            <div class="col-lg-12">
                                                                <ul class="list-unstyled">
                                                                    @foreach ($kategori->content as $content)
                                                                        <li><a class="dropdown-item" href="{{ url('produk/'.$kategori->nama.'/'.$content->id) }}">{{ $content->judul }}</a></li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <!--/column -->
                                                        </div>
                                                        <!--/.row -->
                                                    </div>
                                                    <!--/column -->
                                                @endforeach
                                            </div>
                                            <!--/.row -->
                                        </li>
                                        <!--/.mega-menu-content-->
                                    </ul>
                                    <!--/.dropdown-menu -->
                                </li>
                      
                      
                    </ul>
                    <!-- /.navbar-nav -->
                    <div class="d-lg-none mt-auto pt-6 pb-6 order-4">
                        <a href="mailto:first.last@email.com" class="link-inverse">info@email.com</a>
                        <br /> 00 (123) 456 78 90 <br />
                        <nav class="nav social social-white mt-4">
                            <a href="#"><i class="uil uil-twitter"></i></a>
                            <a href="#"><i class="uil uil-facebook-f"></i></a>
                            <a href="#"><i class="uil uil-dribbble"></i></a>
                            <a href="#"><i class="uil uil-instagram"></i></a>
                            <a href="#"><i class="uil uil-youtube"></i></a>
                        </nav>
                        <!-- /.social -->
                    </div>
                    <!-- /offcanvas-nav-other -->
                </div>
                <!-- /.offcanvas-body -->
            </div>
            <!-- /.navbar-collapse -->
            <div class="navbar-other ms-lg-4">
                <ul class="navbar-nav flex-row align-items-center ms-auto">
                    <li class="nav-item d-none d-lg-block">
                        <a href="https://web.whatsapp.com/send?phone={{ !empty($config) ? $config['wa'] : '' }}&amp;text={{ $text }}"
                            target="_blank" class="btn btn-circle btn-sm btn-green"><i class="uil uil-whatsapp"></i></a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="https://api.whatsapp.com/send?phone={{ !empty($config) ? $config['wa'] : '' }}&amp;text={{ $text }}"
                            target="_blank" class="btn btn-circle btn-sm btn-green"><i class="uil uil-whatsapp"></i></a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <button class="hamburger offcanvas-nav-btn"><span></span></button>
                    </li>
                </ul>
                <!-- /.navbar-nav -->
            </div>
            <!-- /.navbar-other -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navbar -->
</header>
<!-- /header -->
