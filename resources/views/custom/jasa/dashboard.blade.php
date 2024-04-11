@php
    $ar = !empty($crud->arUser) ? $crud->arUser->kode : 'semua';
    $list_ar = $crud->ar;
    $list_ar['semua'] = 'semua';
@endphp

@section('main')
    <div id="app">

        @component('tafio::widgets.header')
            Dashboard
            <x-tafio::custom.panah />
            Produksi

            @slot('kanan')
                <div class='pull-right m-r-20'>
                    {!! link_biasa('bisnis/jasa/project/create', 'tambah order', 'btn btn-success btn-rounded', 'popup') !!}
                </div>

                <div class='pull-right m-r-20'>
                    @if (count($crud->ar) > 1)
                        <div class="input-group"> <span class="input-group-addon" id="basic-addon2">AR</span>
                            <x-tafio::form.select name="ar" :options="$list_ar" :attribute="['v-model' => 'ar', 'class' => 'form-control col-md-8']" />
                        </div>
                    @endif
                </div>
            @endslot
        @endcomponent

        <div class="container-fluid r-aside">
            <div class="row p-30">
                <div class="col-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($crud->grups as $grup)
                        <li class="nav-item"> <a class="nav-link {{ $grup->nama == 'awal' ? 'active' :'' }}" data-toggle="tab" href="#{{ $grup->nama }}" role="tab"
                            aria-expanded="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                class="hidden-xs-down">{{ $grup->nama }}</span><span class="badge badge-success ml-2">
                                <?php $jumlah=123;
                                
                                
                                echo $grup->totalOrder;
                                ?>    
                                
                                
                                </span></a> </li>
                        @endforeach
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        @foreach ($crud->grups as $grup)
                        <div class="tab-pane {{ $grup->nama == 'awal' ? 'active' :'' }}" id="{{ $grup->nama }}" role="tabpanel" aria-expanded="true">
                            <div class="card">
                                <div class="card-body">
                                    @foreach ($grup->projectFlow()->orderBy('urutan')->get() as $projectFlow)
                                                <div class="card">
                                                    <div class="card-body card-judul">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h4 class="card-title"><span
                                                                        class="lstick"></span>{{ $projectFlow->nama }}</h4>
                                                            </div>
                                                            <div class="ml-auto"></div>
                                                        </div>
                                                        <div class="message-box contact-box">
                                                            <div class="message-widget contact-widget">
                                                                @if ($projectFlow->project_detail)
                                                                    {!! grouping(
                                                                        $projectFlow->project_detail()->cabang(session('cabang'))->where('project_details.company_id', session('company'))->orderByDesc('projects.id')->get(),
                                                                    ) !!}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div> <!-- / #project -->
            </div> <!-- / #project -->
        </div> <!-- / #project -->
    </div> <!-- / #project -->

    {!! script_ar($list_ar, $ar) !!}

@endsection

@push('addons-script')
    <style>
        .card-judul {
            border-radius: 8px;
            box-shadow: 2px 9px 33px -7px rgba(179, 179, 179, 0.75);
            -webkit-box-shadow: 2px 9px 33px -7px rgba(179, 179, 179, 0.75);
            -moz-box-shadow: 2px 9px 33px -7px rgba(179, 179, 179, 0.75);
        }
    </style>
@endpush
