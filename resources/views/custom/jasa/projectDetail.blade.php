@php
    $proses = $crud->proses;
    $pemproses = [];
    array_push($pemproses, 'blm');
    foreach ($proses as $value) {
        $pemproses[$value->id] = $value->nama;
    }
    
    $pengirimanx = ['diambil' => 'diambil', 'diantar' => 'diantar ke alamat', 'jasa' => 'pakai jasa pengiriman'];
    $invoicex = ['disertakan' => 'disertakan dengan barang', 'terpisah' => 'dikirim terpisah', 'email' => 'diemail', 'tidak' => 'tidak pakai'];
@endphp

@include('custom.jasa.header')

{{-- add list order --}}
@include('custom.jasa.card_order')

@include('custom.jasa.cardJadwal')

@component('tafio::widgets.card')
    <div class="row">
        <div class="col-lg-6">
            <div class=row>
                <div class='col-lg-4'>
                    <div class="d-flex" style='margin-top:-70px;margin-bottom:-10px'>
                        <div class="display-6 text-info p-t-0"><i class="ti ti-truck"></i></div>
                        <div class="m-l-20">
        
                            <h4 class="m-b-0">pengiriman</h4>
                            @if (!empty($crud->projects->pengiriman))
                                <h6>{{ $pengirimanx[$crud->projects->pengiriman] }}</h6>
                            @else
                                <h6>tidak ada informasi</h6>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($crud->projects->pengiriman == 'jasa')
                <div class='col-lg-4'>
                    <h5>Jasa pengiriman</h5>
                    {!! $crud->projects->jasa !!}
                </div>
                <div class='col-lg-4'>
                    <h5>Ongkir</h5>
                    {!! uang($crud->projects->ongkir) !!}
                </div>
                @endif
            </div>
        
            @if (!empty($crud->projects->pengiriman))
                <hr class='m-b-10 m-t-30'>
                <div class="row">
                    @if (!empty($crud->projects->invoice))
                        <div class="col">
                            <h5>Invoice</h5>
                            <h6>{!! $invoicex[$crud->projects->invoice] !!}</h6>
                        </div>
                    @endif
                    @if ($crud->projects->pengiriman == 'diambil' or $crud->projects->pengiriman == 'diantar')
                        <div class="col">
                            <h5>Pembayaran</h5>
                            {!! $crud->projects->jenis_pembayaran !!}
                        </div>
                    @endif
                    @if (!empty($crud->projects->ket_kirim))
                        <div class="col">
                            <h5> keterangan lainnya </h5>
                            {!! $crud->projects->ket_kirim !!}
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="col-lg-6" style="margin-top:-70px">
            @include('tafio::widgets.chat', ['table_name' => 'project', 'table_id' => $crud->projects->id])
        </div>
    </div>
@endcomponent
