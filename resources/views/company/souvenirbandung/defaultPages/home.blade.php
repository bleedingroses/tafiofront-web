@extends($folder . 'layouts.main')

@section('main')
    <section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-300" data-image-src="{{ asset($company->name . '/img/bg16.png') }}">
        <div class="container pt-17 pb-19 pt-md-18 pb-md-17 text-center">
            <div class="row">
                <div class="col-lg-8 col-xl-7 col-xxl-6 mx-auto" data-cues="slideInDown" data-group="page-title">
                    <h1 class="display-1 text-white fs-60 mb-4 px-md-15 px-lg-0">We bring solutions to make life <span
                            class="underline-3 style-2 yellow">easier</span></h1>
                    <p class="lead fs-24 text-white lh-sm mb-7 mx-md-13 mx-lg-10">We are a creative company that focuses on
                        long term relationships with customers.</p>
                    <div>
                        <a class="btn btn-white rounded mb-10 mb-xxl-5">Read More</a>
                    </div>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
        <div class="overflow-hidden">
            <div class="divider text-light mx-n2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 60">
                    <path fill="currentColor" d="M0,0V60H1440V0A5771,5771,0,0,1,0,0Z" />
                </svg>
            </div>
        </div>
    </section>
    <!-- /section -->
    <section class="wrapper bg-light">
        <div class="container pb-15 pb-md-17">
            <div class="row gx-md-5 gy-5 mt-n19 mb-14 mb-md-17">
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="{{ asset($company->name . '/img/icons/solid/edit.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-fuchsia mb-3" alt="" />
                            <h4>Content Marketing</h4>
                            <p class="mb-2">Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida
                                at eget metus cras justo.</p>
                            <a href="#" class="more hover link-fuchsia">Learn More</a>
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/column -->
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="{{ asset($company->name . '/img/icons/solid/team.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-violet mb-3" alt="" />
                            <h4>Social Engagement</h4>
                            <p class="mb-2">Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida
                                at eget metus cras justo.</p>
                            <a href="#" class="more hover link-violet">Learn More</a>
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/column -->
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="{{ asset($company->name . '/img/icons/solid/lamp.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-orange mb-3" alt="" />
                            <h4>Identity & Branding</h4>
                            <p class="mb-2">Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida
                                at eget metus cras justo.</p>
                            <a href="#" class="more hover link-orange">Learn More</a>
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/column -->
                <div class="col-md-6 col-xl-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <img src="{{ asset($company->name . '/img/icons/solid/delivery-box.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-green mb-3" alt="" />
                            <h4>Product Design</h4>
                            <p class="mb-2">Nulla vitae elit libero, a pharetra augue. Donec id elit non mi porta gravida
                                at eget metus cras justo.</p>
                            <a href="#" class="more hover link-green">Learn More</a>
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/column -->
            </div>
            <!--/.row -->
            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2 mx-auto text-center">
                    <h2 class="fs-16 text-uppercase text-muted mb-3">Why Choose Sandbox?</h2>
                    <h3 class="display-3 mb-10 px-xl-10 px-xxl-15">Here are a few <span
                            class="underline-3 style-2 yellow">reasons</span> why our customers choose Sandbox.</h3>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
            <ul
                class="nav nav-tabs nav-tabs-bg nav-tabs-shadow-lg d-flex justify-content-between nav-justified flex-lg-row flex-column">
                <li class="nav-item"> <a class="nav-link d-flex flex-row active" data-bs-toggle="tab" href="#tab2-1">
                        <div><img src="{{ asset($company->name . '/img/icons/solid/bulb.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-fuchsia me-4" alt="" /></div>
                        <div>
                            <h4>Collect Ideas</h4>
                            <p>Duis mollis commodo luctus cursus commodo tortor mauris.</p>
                        </div>
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex flex-row" data-bs-toggle="tab" href="#tab2-2">
                        <div><img src="{{ asset($company->name . '/img/icons/solid/compare.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-violet me-4" alt="" /></div>
                        <div>
                            <h4>Data Analysis</h4>
                            <p>Vivamus sagittis lacus augue fusce dapibus tellus nibh.</p>
                        </div>
                    </a> </li>
                <li class="nav-item"> <a class="nav-link d-flex flex-row" data-bs-toggle="tab" href="#tab2-3">
                        <div><img src="{{ asset($company->name . '/img/icons/solid/delivery-box.svg') }}"
                                class="svg-inject icon-svg icon-svg-sm solid-mono text-green me-4" alt="" /></div>
                        <div>
                            <h4>Finalize Product</h4>
                            <p>Vestibulum ligula porta felis maecenas faucibus mollis.</p>
                        </div>
                    </a> </li>
            </ul>
            <!-- /.nav-tabs -->
            <div class="tab-content mt-6 mt-lg-8">
                <div class="tab-pane fade show active" id="tab2-1">
                    <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                        <div class="col-lg-6">
                            <figure class="rounded shadow-lg"><img src="{{ asset($company->name . '/img/se5.jpg') }}"
                                    srcset="{{ asset($company->name . '/img/se5.jpg') }}" alt=""></figure>
                        </div>
                        <!--/column -->
                        <div class="col-lg-6">
                            <h2 class="mb-3">Collect Ideas</h2>
                            <p>Etiam porta sem malesuada magna mollis euismod. Donec ullamcorper nulla non metus auctor
                                fringilla. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus,
                                tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
                                risus. Nullam quis risus eget urna.</p>
                            <ul class="icon-list bullet-bg bullet-soft-fuchsia">
                                <li><i class="uil uil-check"></i>Aenean eu leo quam. Pellentesque ornare.</li>
                                <li><i class="uil uil-check"></i>Nullam quis risus eget urna mollis ornare.</li>
                                <li><i class="uil uil-check"></i>Donec id elit non mi porta gravida at eget.</li>
                            </ul>
                            <a href="#" class="btn btn-fuchsia mt-2">Learn More</a>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/.tab-pane -->
                <div class="tab-pane fade" id="tab2-2">
                    <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                        <div class="col-lg-6 order-lg-2">
                            <figure class="rounded shadow-lg"><img src="./assets/img/photos/se6.jpg"
                                    srcset="./assets/img/photos/se6@2x.jpg 2x" alt=""></figure>
                        </div>
                        <!--/column -->
                        <div class="col-lg-6">
                            <h2 class="mb-3">Data Analysis</h2>
                            <p>Etiam porta sem malesuada magna mollis euismod. Donec ullamcorper nulla non metus auctor
                                fringilla. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus,
                                tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
                                risus. Nullam quis risus eget urna.</p>
                            <ul class="icon-list bullet-bg bullet-soft-violet">
                                <li><i class="uil uil-check"></i>Aenean eu leo quam. Pellentesque ornare.</li>
                                <li><i class="uil uil-check"></i>Nullam quis risus eget urna mollis ornare.</li>
                                <li><i class="uil uil-check"></i>Donec id elit non mi porta gravida at eget.</li>
                            </ul>
                            <a href="#" class="btn btn-violet mt-2">Learn More</a>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/.tab-pane -->
                <div class="tab-pane fade" id="tab2-3">
                    <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
                        <div class="col-lg-6">
                            <figure class="rounded shadow-lg"><img src="./assets/img/photos/se7.jpg"
                                    srcset="./assets/img/photos/se7@2x.jpg 2x" alt=""></figure>
                        </div>
                        <!--/column -->
                        <div class="col-lg-6">
                            <h2 class="mb-3">Finalize Product</h2>
                            <p>Etiam porta sem malesuada magna mollis euismod. Donec ullamcorper nulla non metus auctor
                                fringilla. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Fusce dapibus,
                                tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet
                                risus. Nullam quis risus eget urna.</p>
                            <ul class="icon-list bullet-bg bullet-soft-green">
                                <li><i class="uil uil-check"></i>Aenean eu leo quam. Pellentesque ornare.</li>
                                <li><i class="uil uil-check"></i>Nullam quis risus eget urna mollis ornare.</li>
                                <li><i class="uil uil-check"></i>Donec id elit non mi porta gravida at eget.</li>
                            </ul>
                            <a href="#" class="btn btn-green mt-2">Learn More</a>
                        </div>
                        <!--/column -->
                    </div>
                    <!--/.row -->
                </div>
                <!--/.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
