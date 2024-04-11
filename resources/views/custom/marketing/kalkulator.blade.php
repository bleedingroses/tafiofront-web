@php
    if (!empty($_GET['alamat'])) {
        $alamat = $_GET['alamat'];
    }
@endphp

@section('main')
    <div id="app">
        @component('tafio::widgets.header')
            kalkulator

            @slot('kanan')
                <div class='pull-right m-r-20'>
                </div>
            @endslot
        @endcomponent
        <div class="container-fluid r-aside">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-xlg-2 col-lg-3 col-md-4">
                                <div class="card-body inbox-panel">
                                    <ul class="list-group list-group-full">
                                        <li @click="showKalkulator(value = 'optimasi')" class="list-group-item" style="cursor: pointer"><i
                                                class="mdi mdi-window-closed"></i> Optimasi Potong</li>
                                        <li @click="showKalkulator(value = 'optimasi_bahan')" class="list-group-item" style="cursor: pointer"><i
                                                class="mdi mdi-map"></i> Optimasi bahan</li>
                                        <li @click="showKalkulator(value = 'optimasi_setting')" class="list-group-item" style="cursor: pointer"><i
                                                class="mdi mdi-wiiu"></i> Optimasi setting</li>
                                        <li @click="showKalkulator(value = 'optimasi_harga')" class="list-group-item" style="cursor: pointer"><i
                                                class="mdi mdi-grid"></i> Hitung Harga</li>
                                        <li @click="showKalkulator(value = 'berat')" class="list-group-item" style="cursor: pointer"><i
                                                class="mdi mdi-calculator"></i> berat kertas</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xlg-10 col-lg-9 col-md-8 bg-light-part b-l">
                                <div class="card-body">
                                    @if (!empty($_GET['alamat']))
                                    @include("calculator.".$alamat."")
                                    @endif                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- / #project -->
    </div> <!-- / #project -->

@stop


@push('addons-script')
    <link href="{{ asset('css/inbox.css') }}" rel="stylesheet">
    <script>
        new Vue({
            el: "#app",
            data: {
                alamat: [],
            },
            methods: {
                showKalkulator(value) {
                    this.alamat = value;
                    window.location.href = "{{ url('bisnis/marketing/kalkulator') }}?alamat=" + this.alamat;
                }
            },
            created() {
                this.$cookie.set("keyName", keyValue, "expiring time")
            }
        });
    </script>
@endpush
