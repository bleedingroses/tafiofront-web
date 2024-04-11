<?php
$proses = false;
if ($crud->po->status == 'proses') {
    $proses = true;
}
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
                                <h6 class="text-muted m-b-0">tanggal po</h6>
                                <h4 class="m-t-0">{{ $crud->po->created_at->format('d-m-Y') }}</h4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-warning m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">supplier</h6>
                                <H4 class="m-t-0">{{ $crud->po->kontak->namaLengkap }}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">perkiraan datang</h6>
                                <H4 class="m-t-0">{{ date('d-m-Y', strtotime($crud->po->tglKedatangan)) }}</H4>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex">
                            <i class="fa fa-circle font-10 m-r-5 text-info m-t-5"></i>
                            <div>
                                <h6 class="text-muted m-b-0">Keterangan</h6>
                                <H4 class="m-t-0">{{ $crud->po->ket }}</H4>
                            </div>
                        </div>
                    </li>
                </ul>

                @if ($proses)
                    <div class="call-to-act">
                        {!! link_biasa('bisnis/stok/po/' . $crud->po->id . '/edit', 'edit', 'btn btn-warning btn-rounded') !!}
                    </div>
                    <form method="POST" action="{{ url('bisnis/stok/po/' . $crud->po->id) }}" accept-charset="UTF-8"
                        onsubmit="document.getElementById('submit').disabled=true;
                        document.getElementById('submit').value='proses'"
                        enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="_method"value="PATCH">
                        <input type="hidden" value="finish" name="status">
                        <div class="isian form-group"><input id="submit" type="submit" value="selesaikan"
                                class="btn btn-info btn-rounded mt-4 ml-2"></div>
                    </form>
                @endif
            </div>
        </nav>
    </div>

</div>

<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h2></h2>
        </div>

        @if ($proses)
            <div>
                {!! button_tambah('bisnis/stok/po/' . $crud->po->id . '/detail/create') !!}
            </div>
        @endif
    </div>
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>tgl</th>
                <th>jumlah</th>
                <th>yg blm</th>
                @if ($proses)
                    <th>action</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->po->poDetail as $item)
                <tr>
                    <td>{{ $item->produk->namaLengkap }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->jumlah - $item->jumlahKedatangan }}</td>
                    @if ($proses)
                        <td>
                            <a href="{{ url('bisnis/stok/po/' . $item->po->id . '/detail/' . $item->id . '/edit') }}"
                                class="btn btn-xs btn-rounded btn-warning pull-left"><i class="fa fa-edit"></i></a>
                            @if ($item->jumlahKedatangan == 0)
                                <form action=" {{ url('bisnis/stok/po/' . $crud->po->id . '/detail/' . $item->id) }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="_method" value="delete"> <button
                                        onclick="return confirm(&quot;Anda yakin akan menghapus data ini?&quot;)"
                                        class="btn btn-xs btn-rounded btn-danger pull-left m-l-5"><i
                                            class="fa fa-trash-o"></i></button>
                                </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h2>Deposit</h2>
        </div>

        @if ($proses)
            <div>
                {!! button_tambah('bisnis/stok/po/' . $crud->po->id . '/deposit/create') !!}
            </div>
        @endif
    </div>
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>tgl</th>
                <th>
                    <div align=right>jumlah</div>
                </th>
                <th>
                    <div align=right>terpakai</div>
                </th>
                <th>
                    <div align=right>penginput</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->kontakKeuangan as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <div align=right>{!! link_biasa('bisnis/data/keuangan/' . $item->id . '/keuanganDetail', uang($item->total), '', 'popup') !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! uang($item->total - $item->kekurangan) !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! $item->user !!}</div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    <div class="d-flex justify-content-between">
        <div>
            <h2>kedatangan</h2>
        </div>

        @if ($proses)
            <div>
                {!! button_tambah('bisnis/stok/po/' . $crud->po->id . '/belanja/create') !!}
            </div>
        @endif
    </div>
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>tgl</th>
                <th>
                    produk
                </th>
                <th>nota</th>
                <th>diskon</th>
                <th>
                    <div align=right>total</div>
                </th>
                <th>
                    <div align=right>kekurangan</div>
                </th>
                <th>
                    <div align=right>penginput</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->po->belanja()->get() as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>{!! link_biasa('bisnis/keuangan/belanja/' . $item->id . '/belanjaDetail', $item->produk, '', 'popup') !!}</td>
                    <td>{{ $item->nota }}</td>
                    <td>
                        <div align=right>{!! uang($item->diskon) !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! uang($item->total) !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! link_biasa(
                            'bisnis/data/keuangan/' . $item->keuangan->id . '/keuanganDetail',
                            uang($item->keuangan->kekurangan),
                            '',
                            'popup',
                        ) !!}</div>
                    </td>
                    <td>
                        <div align=right>{!! $item->user !!}</div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
