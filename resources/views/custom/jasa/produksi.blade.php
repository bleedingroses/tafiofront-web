<div id="produksi">
    <div class="row">
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">produk</h6>
                    <h2 class="m-t-0">{{ $crud->produksi->produk->namaLengkap }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">total biaya</h6>
                    <h2 class="m-t-0">{{ number_format($crud->produksi->biaya, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">target</h6>
                    <h2 class="m-t-0">{{ $crud->produksi->target }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">hasil</h6>
                    <h2 class="m-t-0">{{ $crud->produksi->hasil }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">hpp</h6>
                    <h2 class="m-t-0">{{ $crud->produksi->hpp }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block">
                        <div class="m-r-20 align-self-center">
                            <font size="10px" color="#398BF7"></font>
                        </div>
                        <div class="align-self-center">
                            <h6 class="text-muted m-t-10 m-b-0">ket</h6>
                            <h2 class="m-t-0">{{ $crud->produksi->ket }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="d-flex no-block">
                <div class="m-r-20 align-self-center">
                    <font size="10px" color="#398BF7"></font>
                </div>
                <div class="align-self-center">
                    <h6 class="text-muted m-t-10 m-b-0">status</h6>
                    <h2 class="m-t-0">{{ $crud->produksi->status }}</h2>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div>
                <a href="{{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/edit') }}"
                    class="btn btn-rounded btn-success popup-tafio">edit data</a>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="card-title">Biaya</h3>
                        <div class="pull-right">
                            <a href="{{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/biaya/create') }}"
                                class="btn btn-rounded btn-success popup-tafio"><i class="fa fa-plus-circle m-r-5"></i>
                                tambah data</a>
                        </div>
                    </div>
                    <table data-toggle="table" data-mobile-responsive="true"
                        class="table-striped baris table table-hover">
                        <thead>
                            <tr>
                                <th style="" data-field="0">
                                    <div class="th-inner ">tanggal</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="1">
                                    <div class="th-inner ">produk</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="2">
                                    <div class="th-inner ">
                                        <div align="right">Jumlah</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="3">
                                    <div class="th-inner ">
                                        <div align="right">Harga</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="4">
                                    <div class="th-inner ">
                                        <div align="right">total</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="5">
                                    <div class="th-inner ">Ket</div>
                                    <div class="fht-cell"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crud->biaya as $biaya)
                                <tr>
                                    <td>{{ $biaya->created_at }}</td>
                                    <td>{{ $biaya->produk->namaLengkap }}</td>
                                    <td>{{ $biaya->jumlah }}</td>
                                    <td>{{ number_format($biaya->harga, 0, ',', '.') }}</td>
                                    <td> <a class="popup-tafio"
                                            href="{{ url('bisnis/data/keuangan/' . $biaya->belanja->keuangan->id . '/keuanganDetail') }}">{{ number_format($biaya->total, 0, ',', '.') }}</a>
                                    </td>
                                    <td>{{ $biaya->ket }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h4 class="card-title mt-4">Bahan</h4>
                        <div class="pull-right">
                            <a href="{{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/bahan/create') }}"
                                class="btn btn-rounded btn-success popup-tafio"><i
                                    class="fa fa-plus-circle m-r-5"></i>
                                tambah data</a>
                        </div>
                    </div>
                    <table data-toggle="table" data-mobile-responsive="true"
                        class="table-striped baris table table-hover">
                        <thead>
                            <tr>
                                <th style="" data-field="0">
                                    <div class="th-inner ">tanggal</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="1">
                                    <div class="th-inner ">produk</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="2">
                                    <div class="th-inner ">
                                        <div align="right">Jumlah</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="3">
                                    <div class="th-inner ">
                                        <div align="right">Harga</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="4">
                                    <div class="th-inner ">
                                        <div align="right">total</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="5">
                                    <div class="th-inner ">Ket</div>
                                    <div class="fht-cell"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crud->bahan as $bahan)
                                <tr>
                                    <td>{{ $bahan->created_at }}</td>
                                    <td>{{ $bahan->produk->namaLengkap }}</td>
                                    <td>{{ $bahan->jumlah }}</td>
                                    <td>{{ number_format($bahan->harga, 0, ',', '.') }}</td>
                                    <td>{{ number_format($bahan->total, 0, ',', '.') }}</td>
                                    <td>{{ $bahan->ket }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h4 class="card-title mt-4">Hasil</h4>
                        <div class="pull-right">
                            <a href="{{ url('bisnis/stok/produksi/' . $crud->produksi->id . '/hasil/create') }}"
                                class="btn btn-rounded btn-success popup-tafio"><i class="fa fa-plus-circle "></i>
                                tambah data</a>
                        </div>
                    </div>
                    <table data-toggle="table" data-mobile-responsive="true"
                        class="table-striped baris table table-hover">
                        <thead>
                            <tr>
                                <th style="" data-field="0">
                                    <div class="th-inner ">tanggal</div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="2">
                                    <div class="th-inner ">
                                        <div align="right">Jumlah</div>
                                    </div>
                                    <div class="fht-cell"></div>
                                </th>
                                <th style="" data-field="5">
                                    <div class="th-inner ">Ket</div>
                                    <div class="fht-cell"></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($crud->hasil as $hasil)
                                <tr>
                                    <td>{{ $hasil->created_at }}</td>
                                    <td>{{ $hasil->jumlah }}</td>
                                    <td>{{ $hasil->ket }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
