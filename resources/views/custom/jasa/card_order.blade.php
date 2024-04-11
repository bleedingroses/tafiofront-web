<div class="card-body">
    <table data-toggle="table" data-mobile-responsive="true" class="table-striped">
        <thead>
            <tr>
                <th>produk</th>
                <th>tema</th>
                <th>jml</th>
                <th>
                    <div align=right>harga</div>
                </th>
                <th><span class=pull-right>sub total</th>
                <th>spesifikasi</th>
                @if (auth()->user()->authlevel_id != 7)
                    <th>status</th>
                @endif
                <th>
                    <div align=center>gbr</div>
                </th>
                <th>
                    <div align=center>deadline</div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($crud->projects->projectDetail as $item)
                <tr
                    @php
                    if (
                        $crud->projects
                            ->projectKomplain()
                            ->where('project_detail_id', $item->id)
                            ->first()
                    ) {
                        echo "class='table-danger'";
                    } @endphp>
                    <td>
                        <small>
                            <a style="font-weight: 600;font-size:15px"
                                href="{{ url('bisnis/jasa/project/' . $crud->projects->id . '/projectDetail/' . $item->id . '/edit') }}">{{ $item->produk->namaLengkap ?? '' }}</a>
                        </small>
                    </td>
                    <td><small> {{ $item->tema }} </td>
                    <td align=right> <small>{{ $item->jumlah }} </td>
                    <td align=right> <small> {!! uang($item->harga) !!} </td>
                    <td align=right> <small>{!! uang($item->harga * $item->jumlah) !!} </td>
                    <td><small>

                            @foreach ($item->spek as $spek)
                                <span style="font-weight: 600"> {{ $spek->nama }}: </span>
                                {{ $spek->pivot->keterangan }},
                            @endforeach

                            @if (!empty($item->keterangan))
                                <span class='text-danger'> keterangan:</span>
                                {{ $item->keterangan }}
                            @endif
                        </small>
                    </td>
                    @if (auth()->user()->authlevel_id != 7)
                        <td><small>




                                    <x-tafio::form.open method="PATCH" :url="'bisnis/jasa/projectDetail/' . $item->id" />
                                    <x-tafio::form.select name="project_flow_id" :options="$crud->projectFlowProduksi" :value="$item->project_flow_id"
                                        :attribute="['onchange' => 'this.form.submit()']" />
                                    </form>

                                <x-tafio::form.open method="PATCH" :url="'bisnis/jasa/projectDetail/' . $item->id" />
                                <x-tafio::form.select name="process_id" :options="$pemproses" :value="$item->process_id"
                                    :attribute="['onchange' => 'this.form.submit()']" />
                                </form>
                        </td>
                    @endif
                    <td align=center>
                        @if (!empty($item->picture))
                            <div class="row el-element-overlay">
                                <div class="el-card-item  p-0">
                                    <div class="el-card-avatar el-overlay-1 m-0 text-center"><img style="height:70px"
                                            src="{{ url('storage/projectDetail/' . $item->picture[0] . $item->picture[1] . '/' . $item->picture[2] . $item->picture[3] . '/' . $item->picture) }}"
                                            alt="">
                                        <div class="el-overlay ">
                                            <ul class="el-info">
                                                <li><a href="{{ url('storage/projectDetail/' . $item->picture[0] . $item->picture[1] . '/' . $item->picture[2] . $item->picture[3] . '/' . $item->picture) }}"
                                                        class="btn default btn-outline btn-xs image-popup-vertical-fit"><i
                                                            class="icon-magnifier"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <i class="fa fa-file-image-o"></i>
                        @endif
                    </td>
                    <td align=center>
                        <small>
                            <a
                                href="{{ url('bisnis/jasa/project/' . $crud->projects->id . '/schedule/' . $item->id . '/edit') }}">
                                @php
                                    echo link_biasa('bisnis/jasa/project/' . $crud->projects->id . '/schedule/' . $item->id . '/edit', $item->deadline ?? 'belum diset');
                                @endphp
                            </a>
                        </small>
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>
</div>
