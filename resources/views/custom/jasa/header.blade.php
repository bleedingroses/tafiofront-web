<div class="row hdr-nav-bar">
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand hidden-lg-up">order Menu</a>
            <a class="navbar-toggler">
                <span class="ti-menu" data-toggle="collapse" data-target="#navbarText"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <!-- Nav item -->
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-success m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">konsumen</h6>
                                <h4 class="m-t-0">
                                    {!! link_biasa(
                                        'bisnis/data/kontak/' . $crud->projects->kontak_id,
                                        $crud->projects->kontak->namaLengkap,
                                        '',
                                        'popup',
                                    ) !!}


                                </h4>

                                @if ($crud->projects->konsumen_detail)
                                    <h6>
                                        {{ $crud->projects->konsumen_detail }}
                                    </h6>
                                @endif
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-warning m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">ongkir</h6>
                                <H4 class="m-t-0">{!! !empty($crud->projects->ongkir) ? uang($crud->projects->ongkir) : 0 !!}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-primary m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">diskon</h6>
                                <H4 class="m-t-0">{!! !empty($crud->projects->diskon) ? uang($crud->projects->diskon) : 0 !!}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-muted m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">total</h6>
                                <h4 class="m-t-0">{!! !empty($crud->projects->total) ? uang($crud->projects->total) : 0 !!}</h4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-10 text-danger m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">pembayaran</h6>
                                <H4 class="m-t-0">{!! uang($crud->projects->total - ($crud->projects->keuangan->kekurangan ?? 0)) !!}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">kekurangan</h6>
                                <H4 class="m-t-0">{!! uang($crud->projects->keuangan->kekurangan ?? 0) !!}</H4>
                            </div>
                        </div>
                    </li>
                </ul>


                <div class="call-to-act">
                    {!! button_tambah('bisnis/jasa/project/' . $crud->projects->id . '/projectDetail/create') !!}
                    {!! link_biasa(
                        'bisnis/jasa/project/' . $crud->projects->id . '/invoice',
                        'invoice',
                        'btn btn-info btn-rounded',
                        'popup',
                    ) !!}

                    @if ($crud->projects->keuangan)
                        {!! link_biasa(
                            'bisnis/data/keuangan/' . $crud->projects->keuangan->id . '/keuanganDetail',
                            'pembayaran',
                            'btn btn-danger btn-rounded',
                            'popup',
                        ) !!}
                    @endif
                    {!! link_biasa('bisnis/jasa/project/' . $crud->projects->id . '/edit', 'edit', 'btn btn-warning btn-rounded') !!}
                </div>
            </div>
        </nav>
    </div>
    <div class="col-md-12">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand hidden-lg-up">order Menu</a>
            <a class="navbar-toggler">
                <span class="ti-menu" data-toggle="collapse" data-target="#navbarText"></span>
            </a>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">tanggal</h6>
                                <H4 class="m-t-0">{!! date('d-m-Y', strtotime($crud->projects->created_at)) !!}</H4>
                            </div>
                        </div>
                    </li>
                    @if ($crud->projects->nota)
                        <li>
                            <div class="d-flex">
                                <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                                <div>
                                    <h6 class="text-muted m-b-0">nota</h6>
                                    <H4 class="m-t-0">{!! $crud->projects->nota !!}</H4>
                                </div>
                            </div>
                        </li>
                    @endif

                    @if (!empty($crud->projects->user))
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">user</h6>
                                <H4 class="m-t-0">{!! $crud->projects->user !!}</H4>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if (!empty($crud->projects->cabang))
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">cabang</h6>
                                <H4 class="m-t-0">{!! $crud->projects->cabang->nama !!}</H4>
                            </div>
                        </div>
                    </li>
                    @endif              
                </ul>
            </div>
        </nav>
    </div>

</div>
