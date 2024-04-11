<?php
$proses=false;
if($crud->produksi->status=='proses')
$proses=true;
?>

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
                                <h6 class="text-muted m-b-0">barang yg di produksi</h6>
                                <h4 class="m-t-0">{{ $crud->produksi->produk->namaLengkap }}</h4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-warning m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">target</h6>
                                <H4 class="m-t-0">{{ $crud->produksi->target }}</H4>
                            </div>
                        </div>
                    </li>



                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">tanggal mulai</h6>
                                <H4 class="m-t-0">{{ $crud->produksi->created_at->format('d-m-Y') }}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-primary m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">keterangan</h6>
                                <H4 class="m-t-0">{{ $crud->produksi->ket }} </H4>
                            </div>
                        </div>
                    </li>
                    <li>

                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-10 text-danger m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">status</h6>
                                <h4 class="m-t-0">{{ $crud->produksi->status }}</h4>
                            </div>
                        </div>
                    </li>

                </ul>

@if($proses)
                <div class="call-to-act">
                    {!! link_biasa('bisnis/stok/produksi/' . $crud->produksi->id . '/edit', 'edit', 'btn btn-warning btn-rounded') !!}
                    {!! link_biasa('bisnis/stok/produksi/' . $crud->produksi->id . '/edit?status=finish', 'selesaikan', 'btn btn-info btn-rounded') !!}
                </div>
                @endif
            </div>
        </nav>
    </div>

</div>

<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h2>ambil bahan di gudang</h2>
        </div>
        
        @if($proses)
        <div>
            {!! button_tambah('bisnis/stok/produksi/' . $crud->produksi->id . '/bahan/create') !!}
        </div>
        @endif
    </div>
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>tgl</th>
                <th>barang</th>
                <th>
                    <div align=right>jumlah</div>
                </th>
                <th>
                    <div align=right>hpp</div>
                <th>keterangan</th>
                <th>penginput</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->produksi->bahan as $item)
                <tr>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->produk->namaLengkap }}</td>
                    <td>
                        <div align=right>{!! uang($item->kurang) !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! uang($item->hpp) !!}</div>
                    </td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->user }}</td>
                    <td>
                        @if($proses)
                        <form action=" {{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/bahan/' . $item->id) }}"
                            method="post">
                            @csrf
                            <input type="hidden" name="_method" value="delete"> <button
                                onclick="return confirm(&quot;Anda yakin akan menghapus data ini?&quot;)"
                                class="btn btn-xs btn-rounded btn-danger pull-left m-l-5"><i
                                    class="fa fa-trash-o"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h2>belanja bahan / pengeluaran</h2>
        </div>

        @if($proses)
        <div>
            {!! button_tambah('bisnis/stok/produksi/' . $crud->produksi->id . '/biaya/create') !!}
        </div>
       @endif
    </div>
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>tgl</th>
                <th>
                    supplier
                </th>
                <th>barang/jasa</th>
                <th>
                    <div align=right>total</div>
                </th>
                <th>
                    <div align=right>kekurangan</div>
                </th>
                <th>
                    <div align=right>penginput</div>
                </th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->produksi->belanja()->get() as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->kontak->namaLengkap }}</td>
                    <td>

 {!! link_biasa( 'bisnis/keuangan/belanja/' . $item->id . '/belanjaDetail',
                            $item->produk, '', 'popup',) !!}
</td>

                    <td>
                        <div align=right>{!! uang($item->total) !!}</div>
                    </td>
                    <td>
                        <div align=right>
                            @if ($item->keuangan->kekurangan)
                            {!! link_biasa( 'bisnis/data/keuangan/' . $item->keuangan->id . '/keuanganDetail',
                            uang($item->keuangan->kekurangan), '', 'popup',) !!}
                            @else
                               0 
                            @endif
                        </div>
                    </td>
                    <td>{{ $item->user }}</td>
                    <td>
                        @if ($item->keuangan->kekurangan == $item->total and $proses)
                            <form
                                action=" {{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/biaya/' . $item->id) }}"
                                method="post">
                                @csrf
                                <input type="hidden" name="_method" value="delete"> <button
                                    onclick="return confirm(&quot;Anda yakin akan menghapus data ini?&quot;)"
                                    class="btn btn-xs btn-rounded btn-danger pull-left m-l-5"><i
                                        class="fa fa-trash-o"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>

<div class="card-body">

    <div class="row">
        <div class="col-lg-6">
            <div class="d-flex justify-content-between">
                <div>
                    <h2>hasil</h2>
                </div>
                <div>
                </div>
            </div>
            <table width=100% cellpadding=5>
                <tr>
                    <td>total biaya</td>
                    <td>{{ number_format($crud->produksi->biaya, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>target produksi</td>
                    <td>{{ number_format($crud->produksi->target, 0, ',', '.') }}</td>
                </tr>
                 
                @if(!$proses)
                
                <tr>
                    <td>hasil produksi</td>
                    <td>{{ $crud->produksi->hasil }}</td>
                </tr>
                
                
                <tr>
                    <td>waktu produksi</td>
                    <td>

<?php

if(!empty($crud->produksi->tanggal_selesai))
{
$datetime1 = new DateTime($crud->produksi->created_at);
$datetime2 = new DateTime($crud->produksi->tanggal_selesai);
$interval = $datetime1->diff($datetime2);
echo $interval->format('%a').' hari';
}
?> 


                    </td>
                </tr>
               
                <tr>
                    <td>hpp</td>
                    <td>{!! !empty($crud->produksi->hpp) ? uang($crud->produksi->hpp) : 0 !!}</td>
                </tr>
@endif

            </table>
        </div>
        <div class="col-lg-6">
            @include('tafio::widgets.chat', [
                'table_name' => 'produksi',
                'table_id' => $crud->produksi->id,
            ])
        </div>
    </div>
</div>
</div>
