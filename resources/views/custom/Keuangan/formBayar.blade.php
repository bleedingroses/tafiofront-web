<?php 

$project=$crud->halaman->parentDataModel;

?>


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
                        <form method="POST" action="{{ url('bisnis/keuangan/project/'.$project->id.'/pembayaran') }}" accept-charset="UTF-8"
                            onsubmit="document.getElementById('submit').disabled=true; document.getElementById('submit').value='proses';"
                            enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div id="" role="tabpanel" class="tab-pane active"><input name="project_id" type="hidden" value="{{ $project->id }}">
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Konsumen
                                    </label> <input readonly="readonly" name="konsumen" type="text" value="{{ $project->kontak->namaLengkap }}"
                                        class="form-control col-md-7">
                                </div> 
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Diskon
                                    </label> <input id="diskon" name="diskon" type="text" onchange="updateSubTotal()" value="{{ $project->diskon }}"
                                        class="form-control col-md-7">
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">total tagihan
                                    </label> <input id="total" readonly="readonly" name="tagihan" type="text" value="{{ $project->total }}"
                                        class="form-control col-md-7">
                                </div>
                               
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Pembayaran
                                    </label> <input id="pembayaran" readonly="readonly" name="pembayaran" type="text" value="{{ $project->pembayaran }}"
                                        class="form-control col-md-7">
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Kekurangan
                                    </label> <input readonly="readonly" id="kekurangan" name="kekurangan" type="text" value="{{ $project->kekurangan }}"
                                        class="form-control col-md-7">
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Jumlah
                                        <font color="red">*</font>
                                    </label> <input id="jumlah" name="jumlah" type="number" value="{{ $project->kekurangan }}" class="form-control col-md-7"
                                        style="width: 70px;">
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">masuk ke rek
                                        <font color="red">*</font>
                                    </label>
                                    <select name="akun_detail_id" class="form-control col-md-7">
                                        <option selected disabled >pilih kas</option>
                                        @foreach ($crud->kas as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Tanggal
                                        <font color="red">*</font>
                                    </label> <input name="tanggal" type="date" class="form-control col-md-7" value="{!!date('Y-m-d')!!}">
                                </div>
                                <div class="isian form-group row">
                                    <label class="control-label col-md-4 text-right">Ket
                                    </label> <input name="ket" type="text" class="form-control col-md-7">
                                </div>
                                <div class="isian form-group"><input id="submit" type="submit" value="simpan"
                                    class="btn btn-primary"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- / #project -->
    </div>
@endsection



@push('addons-script')
    <script>
        function updateSubTotal() {
            let total = document.getElementById('total');
            let diskon = document.getElementById('diskon');
            let jumlah = document.getElementById('jumlah');
            let kekurangan = document.getElementById('kekurangan');
            let pembayaran = document.getElementById('pembayaran');
            total.value = <?php echo $project->total + $project->diskon ?> - diskon.value;
            kekurangan.value = jumlah.value=total.value  - pembayaran.value;
        }
    </script>
@endpush


