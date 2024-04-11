@php
    $ar_user = !empty($crud->arUser) ? $crud->arUser->kode : 'semua';
    $list_ar = $crud->ar;
    $list_ar['semua'] = 'semua';
@endphp

@extends('tafio::layouts.main')

@section('main')
    <div id="app">

        @component('tafio::widgets.header')
            Marketing
            <x-tafio::custom.panah />
            dashboard
            @slot('kanan')
                <div class='pull-right m-r-20'>
                    @if (count($crud->ar) > 2)
                        <div class="input-group"> <span class="input-group-addon" id="basic-addon2">AR</span>
                     
 <x-tafio::form.select name="ar" :options="$list_ar"  :attribute="['v-model'=>'ar','class' => 'form-control col-md-8']" />
                     
                        </div>
                    @endif
                </div>
            @endslot
        @endcomponent

        <div class="container-fluid r-aside">

            <div class="row">
                <div class="col-lg-6">
                    <div class="card-header card-text">
                        <div class="pull-left">
                            <h4>Terdaftar</h4>
                        </div>
                        <div class="text-right">
                            {!! link_biasa(
                                'bisnis/marketing/projectMarketing/create',
                                "<i class='fa fa-plus-circle m-r-5'></i>add",
                                'btn btn-sm btn-rounded btn-success',
                                'popup',
                            ) !!}
                        </div>
                    </div>

                    @component('tafio::widgets.card2')
                        @foreach ($crud->terdaftar as $item)
                            <?php
                            if ($item->ar) {
                                $ar = $item->ar;
                            }
                            $tampilan = '';
                            $kode = !empty($ar) ? $ar->kode : '';
                            $warna = !empty($ar) ? $ar->warna : '';
                            $tampilan .= "<a class='popup-tafio'  href='" . url('bisnis/marketing/projectMarketing/' . $item->id) . "' v-show=" . $kode . " ><p class='text-success' style='font-weight: 600;margin-bottom:0 !important'>";
                            
                            if (!empty($ar)) {
                                $tampilan .= " <span class='label label-rounded' style='background-color: " . $warna . "'> " . $kode . '  </span> ';
                            }
                            $tampilan .= (!empty($item->kontak) ? $item->kontak->namaLengkap : '') . " <span style='color: rgb(99, 99, 99);font-weight: 400 !important'>" . $item->pertanyaan . '</span>';
                            $tampilan .= '<span class="pull-right">' . $item->followup_next . ' </span></p>';
                            echo $tampilan;
                            ?>
                        @endforeach
                    @endcomponent
                </div>
                <div class="col-lg-6">
                    <div class="card-header card-text">
                        <div class="pull-left">
                            <h4>Belum Terdaftar</h4>
                        </div>
                        <div class="text-right">
                            {!! link_biasa(
                                'bisnis/marketing/projectMarketing/create?calon=1',
                                "<i class='fa fa-plus-circle m-r-5'></i>add",
                                'btn btn-sm btn-rounded btn-success',
                                'popup',
                            ) !!}
                        </div>
                    </div>

                    @component('tafio::widgets.card2')
                        @foreach ($crud->blmTerdaftar as $item)
                            <?php
                            if ($item->ar) {
                                $ar = $item->ar;
                            }
                            $tampilan = '';
                            $kode = !empty($ar) ? $ar->kode : '';
                            $warna = !empty($ar) ? $ar->warna : '';
                            $tampilan .= "<a class='popup-tafio'  href='" . url('bisnis/marketing/projectMarketing/' . $item->id) . "' v-show=" . $kode . " ><p class='text-success' style='font-weight: 600;margin-bottom:0 !important'>";
                            
                            if (!empty($ar)) {
                                $tampilan .= " <span class='label label-rounded' style='background-color: " . $warna . "'> " . $kode . '  </span> ';
                            }
                            $tampilan .= $item->perusahaan . " <span style='color: rgb(99, 99, 99);font-weight: 400 !important'>" . $item->pertanyaan . '</span>';
                            $tampilan .= '<span class="pull-right">' . $item->followup_next . ' </span></p>';
                            echo $tampilan;
                            ?>
                        @endforeach
                    @endcomponent
                </div>

            </div>
        </div>
    </div>
    {!! script_ar($list_ar, $ar_user) !!}
@endsection

@push('crud_fields_scripts')
    <style>
        .card-text {
            background-color: rgb(214, 239, 255) !important;
        }
    </style>
@endpush
