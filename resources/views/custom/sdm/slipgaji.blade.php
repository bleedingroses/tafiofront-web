@php
$idPenggajian = $_GET['idSLipGaji'];
$penggajian = App\Tafio\bisnis\src\Models\penggajian::where('id', $idPenggajian)->first();
$hijriyah_skr = tgl_hijriyah();
$tahun_skr = $hijriyah_skr['tahun'];
$bulan_skr = $hijriyah_skr['bulan'];
$bulan = bln_hijriyah($bulan_skr);
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card card-body printableArea m-b-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <img src="{{ url('storage/setting/' . $crud->logo[0] . $crud->logo[1] . '/' . $crud->logo[2] . $crud->logo[3] . '/' . $crud->logo) }}"
                            style="width: 200px" class=" w-1">
                    </div>
                    <div class="pull-right text-right">
                        <address>
                            <h3> &nbsp;<b class="text-info">Office </b></h3>
                            <p class="text-muted m-l-5"> {!! html_entity_decode($crud->alamatKantor) !!} </p>
                        </address>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="hr-invoice">
                    <div class="pull-left">
                        <address>
                            <h4 class="m-b-0">kepada: <br> {{ $penggajian->member->kontak->namaLengkap }} </h4>
                            <p class="text-muted m-t-0">{{ $penggajian->member->alamat }}</p>
                        </address>
                    </div>
                    <div class="pull-right text-right">
                        <p>
                            <b>bulan : {{ $bulan }}</b>
                            <br> <i class="fa fa-calendar"></i> {{ date_format($penggajian->created_at, 'd-m-Y') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th style="width: 500px" class="text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($penggajian->pokok != 0)
                                    <tr>
                                        <td>Gaji Pokok</td>
                                        <td class="text-right">{!! uang((float)$penggajian->pokok) !!}</td>
                                    </tr>
                                @endif
                                @if ($penggajian->lama_kerja != 0)
                                    <tr>
                                        <td>Tunjangan Lama Kerja</td>
                                        <td class="text-right">{!! uang((float)$penggajian->lama_kerja) !!}</td>
                                    </tr>
                                @endif
                                @if ($penggajian->bagian != 0)
                                    <tr>
                                        <td>Tunjangan Bagian</td>
                                        <td class="text-right">{!! uang((float)$penggajian->bagian) !!}</td>
                                    </tr>
                                @endif
                                @if ($penggajian->performance != 0)
                                    <tr>
                                        <td>Tunjangan Performance</td>
                                        <td class="text-right">{!! uang((float)$penggajian->performance) !!}</td>
                                    </tr>
                                @endif
                                @if ($penggajian->transportasi != 0)
                                <tr>
                                    <td>Tunjangan transportasi</td>
                                    <td class="text-right">{!! uang((float)$penggajian->transportasi) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->komunikasi != 0)
                                <tr>
                                    <td>Tunjangan komunikasi</td>
                                    <td class="text-right">{!! uang((float)$penggajian->komunikasi) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->kehadiran != 0)
                                <tr>
                                    <td>Tunjangan Kehadiran</td>
                                    <td class="text-right">{!! uang((float)$penggajian->kehadiran) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->lain2 != 0)
                                <tr>
                                    <td>Tunjangan lainnya</td>
                                    <td class="text-right">{!! uang((float)$penggajian->lain2) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->jumlah_lain != 0)
                                <tr>
                                    <td>Tunjangan Jumlah lainnya</td>
                                    <td class="text-right">{!! uang((float)$penggajian->jumlah_lain) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->keluarga != 0)
                                <tr>
                                    <td>Tunjangan keluarga</td>
                                    <td class="text-right">{!! uang((float)$penggajian->keluarga) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->lembur != 0)
                                <tr>
                                    <td>Tunjangan lembur {{ $penggajian->jam_lembur }}</td>
                                    <td class="text-right">{!! uang((float)$penggajian->lembur) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->potongan != 0)
                                <tr>
                                    <td>Potongan</td>
                                    <td class="text-right">{!! uang((float)$penggajian->potongan) !!}</td>
                                </tr>
                                @endif
                                @if ($penggajian->kasbon != 0)
                                <tr>
                                    <td>Kasbon</td>
                                    <td class="text-right inline-block">
                                        - {{ number_format($penggajian->kasbon, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <hr>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-6 pull-left">
                        <div class="m-b-20" style="font-weight: 400">
                            hormat kami
                        </div>
                        <div class="m-t-40" style="font-weight: 400">
                            (_________)
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <div class="text-right">
                            <div style="font-weight: 600">
                                Total : {{ number_format($penggajian->total, 0, ',', '.') }}
                            </div>                            
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="pull-right m-r-20">
            <button id="print" class="btn btn-primary m-t-15" type="button"> <span><i
                class="fa fa-print"></i> Print</span> </button>
        </div>
    </div>
</div>

@push('addons-script')
    <script src="{{ asset('js/jquery.PrintArea.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script>
@endpush
