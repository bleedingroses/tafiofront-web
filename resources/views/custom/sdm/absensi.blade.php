@section('main')
    <form id="absensi" method="POST" action="{{ url('bisnis/data/absensi') }}" accept-charset="UTF-8"
        enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <input onchange="myFunction()" id="rfid" class="form-control" name="rfid" type="text" autofocus>
    </form>
    <div id="app">
        @component('tafio::widgets.header')
            Absensi Hari Ini
            <x-tafio::custom.panah />
            {{ date('d-m-Y') }}
        @endcomponent
        <div class="container-fluid r-aside">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div style="clear: both;"></div>
                            <div class="bootstrap-table">
                                <div class="fixed-table-toolbar"></div>
                                <div class="fixed-table-container" style="padding-bottom: 0px;">
                                    <div class="fixed-table-header" style="display: none;">
                                        <table></table>
                                    </div>
                                    <div class="fixed-table-body">
                                        <table data-toggle="table" data-mobile-responsive="true"
                                            class="table-striped baris table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>member</th>
                                                    <th>clock in</th>
                                                    <th>clock out</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($crud->absensi as $item)
                                                    <tr>
                                                        <td>{!! link_biasa(
                                                            'bisnis/sdm/member/' . $item->member_id . '/absen',
                                                            $item->member->nama,
                                                            'btn btn-info btn-rounded',
                                                            'popup',
                                                        ) !!}</td>
                                                        <td>{{ $item->in }}</td>
                                                        <td>{{ $item->out }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="fixed-table-footer" style="display: none;">
                                        <table>
                                            <tbody>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="fixed-table-pagination" style="display: none;"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addons-script')
    <script>
        function myFunction() {
            console.log('test');
            document.forms["absensi"].submit();
        }
    </script>
    <style>
        #absensi {
            position: absolute;
            top: -90px;
            opacity: 0;
        }
    </style>
@endpush
