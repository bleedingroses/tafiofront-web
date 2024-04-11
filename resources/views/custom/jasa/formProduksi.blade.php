@section('main')
    <div id="app">
        @component('tafio::widgets.header')
            Produksi
            <x-tafio::custom.panah />
            Biaya bayar
        @endcomponent
        <div class="container-fluid r-aside">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <form method="POST"
                            action="{{ url('bisnis/data/produksi/' . $crud->idProduksi . '/biaya/' . $crud->idBiaya . '/bayar') }}"
                            accept-charset="UTF-8"
                            onsubmit="document.getElementById('submit').disabled=true; document.getElementById('submit').value='proses';"
                            enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectall" class="regular-checkbox" /><label
                                                for="selectall"></th>
                                        <th>produk</th>
                                        <th>
                                            <div align=right>jumlah</div>
                                        </th>
                                        <th>
                                            <div align=right>harga</div>
                                        </th>
                                        <th>ket</th>
                                        <th>
                                            <div align=right>subtotal</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="products">
                                    @foreach ($crud->biaya as $item)
                                        <tr>
                                            <td width="20" align="center"><input type="checkbox" name="biayaId"
                                                    dataId="{{ $item->id }}" class="regular-checkbox name"
                                                    value="{{ $item->jumlah * $item->harga }}"
                                                    id="checkbox-{{ $item->id }}" /><label
                                                    for="checkbox-{{ $item->id }}"></label></td>
                                            <td>{{ $item->produk->namaLengkap }}</td>
                                            <td>
                                                <div align=right>{{ number_format($item->jumlah, 0, ',', '.') }}</div>
                                            </td>
                                            <td>
                                                <div align=right>{{ number_format($item->harga, 0, ',', '.') }}</div>
                                            </td>
                                            <td>{{ $item->ket }}</td>
                                            <td>
                                                <div align=right>{{ number_format($item->total, 0, ',', '.') }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right">Total:</td>
                                        <td>
                                            <input class="form-control" name="total" id="total" type="number"
                                                readonly>
                                            <input id="biaya" type="hidden" name="biaya[]">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div align="right">dibayar dari kas</div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-cash"></i>
                                                    <span class="m-l-10">kas</span>
                                                </div>
                                                <select name="akun_detail_id" class="form-select">
                                                    @foreach ($crud->kas as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="isian form-group"><input id="submit" type="submit" value="simpan"
                                    class="btn btn-primary"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / #project -->
@endsection
@push('addons-script')
    <script type="text/javascript">
        $(function() {
            let biaya = document.getElementById('biaya');
            let id = new Array();

            $("#selectall").click(function() {
                let sum = 0;
                let total = document.querySelector('#total');
                $('.name').prop('checked', this.checked);
                if (this.checked) {
                    $('.name').each(function() {
                        sum += +$(this).val();
                        id.push(test(this.id));
                        biaya.value = id;
                    });
                    total.value = sum;
                } else {
                    total.value = 0;
                }
            });

            $(".name").click(function() {
                if ($(".name").length == $(".name:checked").length) {
                    $("#selectall").prop("checked", "checked");
                } else {
                    $("#selectall").removeAttr("checked");
                }
                if (this.checked) {
                    total.value = +total.value + +this.value;
                    id.push(test(this.id));
                    biaya.value = id;
                } else {
                    total.value = +total.value + -this.value;
                    const index = id.indexOf(test(this.id));
                    if (index > -1) { // only splice id when item is found
                        id.splice(index, 1); // 2nd parameter means remove one item only
                    }
                    biaya.value = id;
                }
            });

            function test(words) {
                var n = words.split("-");
                return n[n.length - 1];
            }
        });
    </script>
@endpush
