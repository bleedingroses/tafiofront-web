
@php
$tahun=$_GET['tahun']??date('Y');
$rutin= App\Models\Jasa\Project::rutin()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$nonrutin= App\Models\Keuangan\Bukubesar::nonrutin()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$penggajian= App\Models\Sdm\Penggajian::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$belanja= App\Models\Keuangan\Belanja::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$tunjangan= App\Models\Sdm\Tunjangan::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
@endphp

      @component('tafio::widgets.before_table')
                @endcomponent

                    <table class="table-striped baris" data-toggle="table"  data-mobile-responsive="true">
                      <thead>
                          <tr>
                            <th>

@foreach (bulan() as $hasil)
  <th>
{{$hasil}}

@endforeach
                          </tr>
                                        </thead>
                      <tbody>

<tr>
<td> <h3>pemasukan
<tr>
<td> rutin
@foreach (bulan() as $key=>$itungan)
  <td>
    @php
      if(empty($rutin[$key]))
        $rutin[$key]=0;
    @endphp
    {!!uang($rutin[$key])!!}
@endforeach
<tr>
<td> non rutin
@foreach (bulan() as $key=>$itungan)
  <td>
    @php
      if(empty($nonrutin[$key]))
        $nonrutin[$key]=0;
    @endphp
    {!!uang($nonrutin[$key])!!}
@endforeach
<tr>
<td> <h3>pengeluaran
<tr>
<td> gaji pegawai
@foreach (bulan() as $key=>$itungan)
  <td>
    @php
      if(empty($penggajian[$key]))
        $penggajian[$key]=0;
    @endphp
    {!!uang($penggajian[$key])!!}
@endforeach
<tr>
<td> tunjangan kesehatan
@foreach (bulan() as $key=>$itungan)
  <td>
    @php
      if(empty($tunjangan[$key]))
        $tunjangan[$key]=0;
    @endphp
    {!!uang($tunjangan[$key])!!}
@endforeach
<tr>
<td> belanja
@foreach (bulan() as $key=>$itungan)
  <td>
    @php
      if(empty($belanja[$key]))
        $belanja[$key]=0;
    @endphp
    {!!uang($belanja[$key])!!}
@endforeach
<tr>
  <td>
  <h3>  total
<tr>
<td>
@foreach (bulan() as $key=>$itungan)
  <td>
{!!uang($rutin[$key]+$nonrutin[$key]-$belanja[$key]-$penggajian[$key]-$tunjangan[$key])!!}
@endforeach

                          </tr>

                      </tbody>


                </table>
