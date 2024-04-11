@section('main')
    <div id="app">
        @component('tafio::widgets.header')
            Add
            <x-tafio::custom.panah />
            Penggajian
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
                        <form method="POST"
                            action="{{ url('bisnis/sdm/member/' . $crud->pegawai->id . '/penggajian') }}"
                            accept-charset="UTF-8"
                            onsubmit="document.getElementById('submit').disabled=true; document.getElementById('submit').value='proses';"
                            enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="form-body">
                                <input type="hidden" name="member_id" value="{{ $crud->pegawai->id }}">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Nama</label>
                                    <div class="col-md-9">
                                        <span style="font-weight: 500">{{ $crud->pegawai->kontak->namaLengkap }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">bagian</label>
                                    <div class="col-md-9">
                                        <span style="font-weight: 500">{{ $crud->bagian->nama }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">level</label>
                                    <div class="col-md-9">
                                        <span style="font-weight: 500">{{ $crud->level->nama }}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Gaji Pokok</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="pokok" id="gapok" type="text"
                                            value="{{ $crud->gapok }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan lama kerja</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="lama_kerja" id="lamaKerja" type="text"
                                            value="{{ $crud->lamaKerja }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan bagian</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="bagian" id="tBagian" type="text"
                                            value="{{ $crud->tBagian }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan performance</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="performance" id="performance"
                                            type="text" value="{{ $crud->performance }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan transportasi</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="transportasi" id="transportasi"
                                            type="text" value="{{ $crud->transportasi }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan komunikasi</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="komunikasi" id="komunikasi"
                                            type="text" value="{{ $crud->level->komunikasi ?? 0 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Tunjangan lain2</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="lain2" id="lain_lain" type="text"
                                            value="{{ $crud->gaji->lain2 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Nilai Tunjangan lain2</label>
                                    <div class="col-md-9">
                                        <input readonly class="form-control" name="jumlah_lain" id="jumlah_lain"
                                            type="number" value="{{ $crud->gaji->jumlah_lain }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">total lembur</label>
                                    <div class="col-md-3">
                                        <span style="font-weight: 500">{{ $crud->jmlLembur }} jam</span>
                                        <input type="hidden" name="jam_lembur" value="{{ $crud->jmlLembur }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">tunjangan lembur</label>
                                    <div class="col-md-3">
                                        <input readonly class="form-control" name="lembur" id="lembur"
                                            type="text" value="{{ $crud->totalLembur }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">tunjangan kehadiran</label>
                                    <div class="col-md-9">
                                        <input @change="getTotal()" type="number" class="form-control" name="kehadiran" id="kehadiran"
                                            value="{{ $crud->level->kehadiran ?? 0 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">potong kasbon</label>
                                    <div class="col-md-9">
                                        <input @change="getTotal()" type="number"
                                            class="form-control" name="kasbon" id="kasbon"
                                            value="{{ $crud->totalKasbon }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">bonus</label>
                                    <div class="col-md-9">
                                        <input @change="getTotal()" type="number" class="form-control" name="bonus" id="bonus" value="0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">total</label>
                                    <div class="col-md-9">
                                        <input readonly v-model="total" type="number" class="form-control"
                                            name="total">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">dari rek <font color=red>*</font></label>
                                    <div class="col-md-9">
                                        <select name="akun_detail_id" class="form-control">
                                            <option value=''>pilih kas</option>
                                            @foreach ($crud->kas as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
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
    <script>
        new Vue({
            el: "#app",
            data: {
                gapok: document.getElementById("gapok").value,
                lamaKerja: document.getElementById("lamaKerja").value,
                tBagian: document.getElementById("tBagian").value,
                performance: document.getElementById("performance").value,
                transportasi: document.getElementById("transportasi").value,
                komunikasi: document.getElementById("komunikasi").value,
                lain_lain: document.getElementById("lain_lain").value,
                jumlah_lain: document.getElementById("jumlah_lain").value,
                lembur: document.getElementById("lembur").value,
                total: ''
            },
            methods: {
                getTotal() {
                    let kasbon = document.getElementById("kasbon").value;
                    let kehadiran = document.getElementById("kehadiran").value;
                    let bonus = document.getElementById("bonus").value;
                    let total = parseInt(this.gapok) + parseInt(this.lamaKerja) + parseInt(this.tBagian) + parseInt(
                            this.performance) +
                        parseInt(this.transportasi) + parseInt(this.komunikasi) + parseInt(this.jumlah_lain) +
                        parseInt(this.lembur) + parseInt(kehadiran) + parseInt(bonus) - parseInt(kasbon);
                    this.total = total;
                }
            },
            mounted: function() {
                this.getTotal();
            },
        });
    </script>
@endpush
