
@push('addons-script')
    <script src="{{ asset('vendor/tafio/js/google_chart.js') }}"></script>
    <script type="text/javascript">
        google.charts.load("current", {
            packages: ["timeline"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var container = document.getElementById('example3.1');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({
                type: 'string',
                id: 'Position'
            });
            dataTable.addColumn({
                type: 'string',
                id: 'Name'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'Start'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'End'
            });
            dataTable.addRows([
                @php
                    foreach ($crud->projects->projectDetail as $item) {
                    
                    
                        if (!empty($item->deadline)) {
                            $pertama = strtotime($crud->projects->created_at);

                                foreach ($item->flow as $schedule ) {
                                    // if ($jadwal->id == $schedule->id) {
                                        $deadline = strtotime($schedule->pivot->deadline);
                                        echo "['" . $item->produk->namaLengkap . ' (' . $item->tema . ")', '" . $schedule->nama . "', new Date(" . date('Y,m-1,d', $pertama) . '), new Date(' . date('Y,m-1,d', $deadline) . ')],';
                                        $pertama = $deadline;
                                    // }
                                }
                            echo "['" . $item->produk->namaLengkap . ' (' . $item->tema . ")', 'deadline', new Date(" . date('Y,m-1,d,0,0', $pertama) . '), new Date(' . date('Y,m-1,d,23,59', strtotime($item->deadline)) . ')],';
                        
                        
                        
                        }
                    }
                @endphp
            ]);

            chart.draw(dataTable);
        }
    </script>
@endpush

<div class="container-fluid" style='margin-top:-20px'>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($crud->projects->projectDetail->first()->deadline != null)
                            <div id="example3.1"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- / #project -->
