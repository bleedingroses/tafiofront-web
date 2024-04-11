
@php
$tahun=$_GET['tahun']??date('Y');
$rutin= App\Models\Jasa\Project::rutin()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$nonrutin= App\Models\Keuangan\Bukubesar::nonrutin()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$penggajian= App\Models\Sdm\Penggajian::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$belanja= App\Models\Keuangan\Belanja::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');
$tunjangan= App\Models\Sdm\Tunjangan::omzet()->whereYear('created_at',$tahun)->pluck('omzet','bulan');


$totalkas=0;
foreach(App\Models\Keuangan\Akundetil::kas()->get() as $kas)
$totalkas+=$kas->saldo;

$piutangdagang=App\Models\Jasa\Project::totalpiutang()->piutang;

@endphp

      @component('tafio::widgets.before_table')
                @endcomponent

                    <table class="table-striped baris" data-toggle="table"  data-mobile-responsive="true">
                      <thead>
                          <tr>
                            <th>akun
                            <th>
<div class=uang>debet</div>
                            <th>
<div class=uang>kredit</div>
                          </tr>
                                        </thead>
                      <tbody>

<tr><td> <h3>kas<td>{!!uang($totalkas)!!}<td></tr>
<tr><td> <h3>piutang<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;piutang dagang<td>{!!uang($piutangdagang)!!}<td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;kasbon pegawai<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;piutang lain2<td><td></tr>
<tr><td> <h3>hutang<td><td></tr>
<tr><td> <h3>modal<td><td></tr>
<tr><td> <h3>prive<td><td></tr>
<tr><td> <h3>pemasukan<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;rutin<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;lain2<td><td></tr>
<tr><td> <h3>pengeluaran<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;gaji pegawai<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;tunjangan pegawai<td><td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;&nbsp;belanja<td><td></tr>
<tr><td> <h3>saldo<td><td></tr>



                      </tbody>


                </table>
