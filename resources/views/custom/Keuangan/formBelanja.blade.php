@section('main')
    <div id="app">
        @component('tafio::widgets.header')
            Belanja
            <x-tafio::custom.panah />
            Detail
        @endcomponent
        <div class="container-fluid r-aside">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="pull-left">
                                <h3 class="card-title">tambah data</h3>
                            </div>
                        </div>
                        <form method="POST" action="<?php echo url($crud->link); ?>" accept-charset="UTF-8"
                            onsubmit="document.getElementById('submit').disabled=true; document.getElementById('submit').value='proses';"
                            enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="col-lg-12 m-t-15">
                                <div class="row">
                                   
                                
                                <div class="col-lg-4">


                                    <input class="form-control" type="date" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>

                                    </div>
                                
                                
                                    <div class="col-lg-4 ms-auto">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span class="m-l-10">no nota</span>
                                                </div>
                                                <input type="number" name="nota" placeholder="no nota">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 m-t-15">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="ti-user"></i>
                                                    <span class="m-l-10">Supplier</span>
                                                </div>
                                                <v-select v-model="suppliers" style="width: 450px" :filterable="false"
                                                    :options="options" @search="onSearch" @input="setSupplier">
                                                    @include('tafio::input.vselect_template')
                                                </v-select>
                                                <input type="hidden" name="supplier_id" v-model="idSupplier" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ms-auto">
                                       
                                    
                                    
                                @if(count(session('totalCabang'))>1)
                                <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <span class="m-l-10">masuk gudang</span>
                                                </div>
                                                <select class="form-control" name="cabang_id" >
                                                    @foreach (session('totalCabang') as $id=>$item)
                                                        <option value="{{ $id }}">{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                @endif
                                    
                                   
                                
                                
                                </div>
                                </div>
                            </div>
                            <div class="table-responsive m-t-15">
                                <table class="table" id="table-barang">
                                    <thead>
                                        <tr style="background-color: #e9ecef">
                                            <th style="width:300px">Barang</th>
                                            <th>keterangan</th>
                                            <th>satuan</th>
                                            <th>jumlah</th>
                                            <th>harga</th>
                                            <th>subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body">
                                        @for ($i = 1; $i < 10; $i++)
                                            <tr>
                                                <td>
                                                    <div id="autocomplete{{ $i }}" class="autocomplete">
                                                        <input id="hasilInput{{ $i }}"
                                                            class="autocomplete-input" />
                                                        <ul class="autocomplete-result-list"></ul>
                                                    </div>
                                                    <input type="hidden" name="barang_beli_id[]"
                                                        id="dataBarang{{ $i }}">
                                                    <span id="closeBrg{{ $i }}"></span>
                                                </td>
                                                <td>
                                                    <input id="ket{{ $i }}" name="keterangan[]"
                                                        class="form-control" type="text" />
                                                </td>
                                                <td>
                                                    <input id="satuan{{ $i }}" readonly class="form-control"
                                                        type="text" />
                                                </td>
                                                <td>
                                                    <input id="jumlah{{ $i }}" name="jumlah[]" step=".01"
                                                        class="form-control" type="number" />
                                                </td>
                                                <td>
                                                    <input id="harga{{ $i }}" name="harga[]" class="form-control" step=".01"
                                                        type="number" />
                                                </td>
                                                <td>
                                                    <input id="subtotal{{ $i }}" readonly
                                                        class="form-control text-right" type="number" />
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <hr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">
                                                <span>diskon</span><br>
                                            </td>
                                            <td class="text-right">
                                                <input onchange="updateSubTotal()" id="diskon" name="diskon"
                                                    class="form-control text-right" type="number" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">
                                                <b><span>Total</span></b> <br>
                                            </td>
                                            <td class="text-right">
                                                <input id="total" name="total" class="form-control text-right" value=0
                                                    type="number" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="text-right">
                                                <b><span>Pembayaran</span></b> <br>
                                            </td>
                                            <td class="text-right">
                                                <input value="0" id="pembayaran" name="pembayaran" @change="kas()"
                                                    class="form-control text-right" type="number" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <div class="input-group" v-if="picked > 0">
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
                            </div>
                            <hr class=" border-secondary">
                            <div class="isian form-group"><input id="submit" type="submit" value="simpan"
                                    class="btn btn-primary"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- / #project -->
    </div>
@endsection



@push('addons-script')
    <link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
    <script src="https://unpkg.com/vue-select@3.0.0"></script>
    <script src="{{ asset('vendor/tafio/js/lodash-4.17.4.min.js') }}"></script>

    <script src="https://unpkg.com/@trevoreyre/autocomplete-js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@trevoreyre/autocomplete-js/dist/style.css" />
    <script>
        Vue.component('v-select', VueSelect.VueSelect);
        new Vue({
            el: "#app",
            data: {
                idSupplier: '',
                suppliers: [],
                options: [],
                picked: '',
            },
            methods: {
                setSupplier(value) {
                    this.idSupplier = value.id;
                },
                onSearch(search, loading) {
                    if (search.length) {
                        loading(true);
                        this.search(loading, search, this);
                    }
                },
                search: _.debounce((loading, search, vm) => {
                    fetch("{{ url('api/bisnis.kontak/supplier?q=') }}" + `${escape(search)}`)
                        .then(res => {
                            res.json().then(json => (vm.options = json));
                            loading(false);
                        });
                }, 350),
                kas() {
                    let pembayaran = document.querySelector("#pembayaran").value;
                    this.picked = pembayaran;
                }
            },
            computed: {}
        });

        for (let i = 1; i < 10; i++) {
            new Autocomplete('#autocomplete' + i, {
                search: input => {
                    const url = "{{ url('api/bisnis.produk/beli?q=') }}" + `${escape(input)}`;
                    return new Promise(resolve => {
                        if (input.length < 1) {
                            return resolve([])
                        }

                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                resolve(data);
                            })
                    })
                },
                getResultValue: result => result.namaLengkap,
                onSubmit: result => {
                    //insert id barang
                    let dataBarang = document.getElementById('dataBarang' + i);
                    dataBarang.value = result.id;

                    //set satuan
                    let satuan = document.getElementById("satuan" + i);
                    satuan.value = result.satuan;

                    //set ket
                    let ket = document.getElementById("ket" + i);

                    //set jumlah
                    let jumlah = document.getElementById("jumlah" + i);
                    jumlah.value = result.jumlah;

                    //set harga
                    let harga = document.getElementById("harga" + i);
                    harga.value = result.harga;
                    harga.onchange = function() {
                        updateHarga(i);
                    };

                    //set subtotal
                    let subtotal = document.getElementById("subtotal" + i);
                    jumlah.onchange = function() {
                        subtotal.value = harga.value * jumlah.value;
                        updateSubTotal();
                    };

                    let btn = document.getElementById("closeBrg" + i);
                    btn.style.display = "block";
                    btn.innerHTML =
                        `<button onclick="clearData(${i})" type="button" class="btn btn-rounded btn-sm btn-warning"><i class="fa fa-remove"></i></button>`;
                },
            })
        }

        function clearData(result) {
            let auto = document.querySelector("#hasilInput" + result);
            auto.value = null;

            //insert id barang  
            let dataBarang = document.getElementById('dataBarang' + result);
            dataBarang.value = null;

            //set satuan
            let satuan = document.getElementById("satuan" + result);
            satuan.value = null;

            //set ket
            let ket = document.getElementById("ket" + result);
            ket.value = null;

            //set jumlah
            let jumlah = document.getElementById("jumlah" + result);
            jumlah.value = null;

            //set harga
            let harga = document.getElementById("harga" + result);
            harga.value = null;

            //set subtotal
            let subtotal = document.getElementById("subtotal" + result);
            subtotal.value = null;

            let btn = document.getElementById("closeBrg" + result);
            btn.style.display = "none";
            updateSubTotal();
        }

        function updateHarga(i) {
            //set jumlah
            let jumlah = document.getElementById("jumlah" + i);
            //set harga
            let harga = document.getElementById("harga" + i);

            //set subtotal
            let subtotal = document.getElementById("subtotal" + i);
            subtotal.value = harga.value * jumlah.value;
            updateSubTotal();
        }

        function updateSubTotal() {
            let sum = [];
            for (let i = 1; i < 10; i++) {
                let subtotal = document.getElementById("subtotal" + i);
                if (subtotal.value != '') {
                    sum.push(parseFloat(subtotal.value));
                }
            }
            let total = document.getElementById('total');
            let diskon = document.getElementById('diskon');
            total.value = sum.reduce((a, b) => a + b, 0) - diskon.value;
        }
    </script>
    @for ($i = 1; $i < 10; $i++)
        <style>
            #closeBrg{{ $i }} {
                position: relative;
            }

            #closeBrg{{ $i }} button {
                position: absolute;
                right: -15px;
                top: -40px;
            }

            .autocomplete-result-list {
                z-index: 50 !important;
            }
        </style>
    @endfor
@endpush
