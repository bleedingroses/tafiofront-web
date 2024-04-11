<?php

namespace App\Tafio\bisnis\src\Halaman\laporan;

use App\Tafio\bisnis\src\Models\produkStok;
use App\Tafio\bisnis\src\Models\project;
use App\Tafio\bisnis\src\Models\kategori;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;




class aset extends Resource
{
    public function config()
    {

        $awal = project::orderBy('created_at')->first()->created_at->year;
        $tahun = [];
        $skr = date('Y');
        for ($i = $skr; $i > $awal; $i--) {
            $tahun[$i] = $i;
        }

        $pilihan = request()->tahun ?? $skr;

        $bulans = array_reverse(bulan(), true);
        if ($pilihan == $skr) {
            $bulan_skr = date('n');
            for ($y = $bulan_skr + 1; $y <= 12; $y++) {
                unset($bulans[$y]);
            }
        }

$simpanan = 'omzetKategori';

// if (Cache::has($simpanan)) {
// $data = Cache::get($simpanan);
// }
// else
{
$ambil=DB::table('project_details')
->selectRaw('cabang_id, project_details.company_id as company,year(projects.created_at) as tahun,produk_kategori_utamas.nama as namaUtama,kategori_utama_id,
produk_kategoris.nama as kategori,kategori_id,month(projects.created_at) as bulan,sum(project_details.harga * jumlah) as omzetKategori') 
->join('produks','produk_id','=','produks.id')
->join('produk_models','produk_model_id','=','produk_models.id')
->join('projects','project_id','=','projects.id')
->join('produk_kategoris','produk_kategoris.id', '=', 'kategori_id')
->join('produk_kategori_utamas','produk_kategori_utamas.id', '=', 'kategori_utama_id')
->groupBy('company','kategori_id','tahun','bulan','cabang_id')
->get();


$data=[];
foreach($ambil as $baris)
{
$data[$baris->company][$baris->tahun][$baris->bulan][$baris->cabang_id][$baris->kategori_id]=$baris->omzetKategori;
}

// dd($data);

Cache::put($simpanan, $data, 86400);
}


        $utama = $kategori = null;
        $awal = true;

        $asetTotal = 0;

$yy=produkStok::lastStok();
            if (session('cabang') != 0) 
                $yy->where('cabang_id', session('cabang'));
            $yy=$yy->get();

$totalAset=0;
            foreach ($yy as $row) {

if(empty($aset[$row->kategori_id]))
$aset[$row->kategori_id]=0;
$aset[$row->kategori_id]+=$row->saldo*$row->hpp;
}

$ambilKategori=kategori::whereHas('kategoriUtama')->orderBy('kategori_utama_id')->get();



        foreach ($ambilKategori as $row) {

$hasil[$row->id]=(object)['id'=>$row->id];
$totalAset+=$hasil[$row->id]->aset=$aset[$row->id]??0;

if($utama!=$row->kategori_utama_id)
$hasil[$row->id]->kategoriUtama=$row->kategoriUtama->nama;
else
$hasil[$row->id]->isiUtama='';

$hasil[$row->id]->kategori=$row->nama;


// dd($data);
        foreach ($bulans as $i => $bulan) {
$xx=$data[session('company')][$pilihan][$i][session('cabang')][$row->id]??0;

$total[$i]=($total[$i]??0)+$xx;
$hasil[$row->id]->{'omzet'.$i}=$xx;
        }
$utama=$row->kategori_utama_id;
}

$hasil['xxx']=(object)['id'=>'xxx','kategoriUtama'=>'<h3>total','aset'=>$totalAset];
        foreach ($bulans as $i => $bulan) {
$hasil['xxx']->{'omzet'.$i} = $total[$i]??0;
}
        


        $this->halaman = (new crud)->make()->projectlist(collect($hasil))
            ->route('index');

        $this->fields = [
            (new select)->make('tahun')->search('noField', 'noQuery')->options($tahun)->default($skr),
            (new noForm)->make('kategoriUtama'),
            (new noForm)->make('kategori')->link('bisnis/laporan/aset/{id}/produk'),
            (new noForm)->make('aset')->uang()];
        // (new noForm)->make('omzet')->uang(),
        foreach ($bulans as $i => $bulan) {
            $this->fields[] = (new noForm)->make('omzet' . $i)->judul($bulan)->uang();

        }

    }
}
