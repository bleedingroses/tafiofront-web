@php
    $project = $crud->project;
    $i = 1;
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="card-body printableArea">
            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        @if (!empty($crud->logo))
                        <img src="{{ url('storage/setting/' . $crud->logo[0] . $crud->logo[1] . '/' . $crud->logo[2] . $crud->logo[3] . '/' . $crud->logo) }}"
                        style="width: 200px" class=" w-1">
                        @endif
                    </div>
                    <div class="pull-right text-right">
                        <address>
                            <h3> &nbsp;<b class="text-info">Office </b></h3>
                            <p class="text-muted m-l-5">{!! html_entity_decode($crud->alamatKantor) !!}</p>
                        </address>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr class="hr-invoice">
                    <div class="pull-left">
                        <address>
                            <h4>kepada: {{ $project->kontak->namaRingkas }}</h4>
                        </address>
                    </div>
                    <div class="pull-right text-right">
                        <p>
                            <b>invoice #{{ $project->id }} </b>
                            <br> <i class="fa fa-calendar"></i> {{ date('d-m-Y', strtotime($project->created_at)) }}
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-20" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>produk</th>
                                    <th>tema</th>
                                    <th class="text-right">Jumlah</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($project->projectDetail as $item)
                                    @if ($item->projectFlow->grup->nama != 'batal')
                                        <tr>
                                            <td class="text-center">{{ $i++ }}</td>
                                            <td>{{ $item->produk->namaLengkap }}</td>
                                            <td>{{ $item->tema }}</td>
                                            <td class="text-right">{!! uang($item->jumlah) !!}</td>
                                            <td class="text-right">{!! uang($item->harga) !!}</td>
                                            <td class="text-right">{!! uang($item->harga * $item->jumlah) !!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="hr-invoice">
                <div class="col-md-12">
                    <div class="table-responsive" style="clear: both;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p class="text-center p-t-10" style="font-size: 12px">hormat kami
                                            <br>
                                            @if (!empty($crud->ar))
                                                @if ($crud->ar->ttd)
                                                    <img id="ttd" style="height:70px; visibility:hidden"
                                                        src="{{ url('storage/ar/' . $crud->ar->ttd[0] . $crud->ar->ttd[1] . '/' . $crud->ar->ttd[2] . $crud->ar->ttd[3] . '/' . $crud->ar->ttd) }}"
                                                        alt="">
                                                @endif
                                            @endif
                                            @if (!empty($crud->stempel))
                                                <img id="stempel"
                                                    style="height:50px; visibility:hidden; position: absolute; left: 70px; bottom: 75px; transform: rotate(-15deg)"
                                                    src="{{ url('storage/setting/' . $crud->stempel[0] . $crud->stempel[1] . '/' . $crud->stempel[2] . $crud->stempel[3] . '/' . $crud->stempel) }}"
                                                    alt="">
                                            @endif
                                            <br>
                                            @if (!empty($crud->member))
                                                @if (!empty($crud->member->kontak))
                                                <span id="ar" onclick="myFunction()">{{ $crud->member->kontak->namaLengkap }}</span>
                                                @endif
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="p-t-10 p-l-20" style="font-size: 12px">pembayaran bisa dilakukan
                                            melalui transfer ke rekening berikut: <br>

                                            {!! str_replace('-', '<br>- ', $crud->rek) !!}

                                        </p>
                                    </td>
                                    <td>
                                        <div class="pull-right text-right m-r-10">
                                            @if ($project->ongkir)
                                                {!! !empty($project->ongkir) ? uang($project->ongkir) : 0 !!}
                                                <div style="font-weight: 600">
                                                    {!! uang($project->total) !!}
                                                </div>
                                            @else
                                                {!! uang($project->total + $project->diskon) !!}
                                            @endif
                                            @php
                                                if (!empty($project->keuangan->keuanganDetail)) {
                                                    $total = 0;
                                                    foreach ($project->keuangan->keuanganDetail as $value) {
                                                        $total += $value->jumlah;
                                                    }
                                                } else {
                                                    $total = 0;
                                                }
                                            @endphp
                                            {{ number_format($total, 0, ',', '.') }}
                                            @if (!empty($project->diskon))
                                                {!! !empty($project->diskon) ? uang($project->diskon) : 0 !!}
                                            @endif
                                            <div style="font-weight: 600">
                                                @if ($project->total == $project->pembayaran)
                                                    0
                                                @else
                                                    {!! !empty($project->keuangan->kekurangan) ? uang($project->keuangan->kekurangan) : 0 !!}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="pull-right text-right m-r-15">
                                            @if ($project->ongkir)
                                                <div>
                                                    ongkir :
                                                </div>
                                                <div style="font-weight: 600">
                                                    Total + Ongkir :
                                                </div>
                                            @else
                                                <div style="font-weight: 600">
                                                    Total :
                                                </div>
                                            @endif
                                            <div>
                                                sudah dibayar :
                                            </div>
                                            @if (!empty($project->diskon))
                                                <div>
                                                    diskon :
                                                </div>
                                            @endif
                                            <div style="font-weight: 600">
                                                kekurangan :
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button id="print" class="btn btn-default float-right" type="button"> <span><i class="fa fa-print"></i>
                Print</span> </button>
    </div>
</div>

<style>
    .hr-invoice {
        border-width: 2px;
    }
</style>


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

        function myFunction() {
            var x = document.getElementById("ttd");
            if (x.style.visibility === "hidden") {
                x.style.visibility = "visible";
            } else {
                x.style.visibility = "hidden";
            }
            var x = document.getElementById("stempel");
            if (x.style.visibility === "hidden") {
                x.style.visibility = "visible";
            } else {
                x.style.visibility = "hidden";
            }
        }
    </script>
@endpush
