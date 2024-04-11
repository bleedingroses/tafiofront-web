<?php

namespace App\Tafio\bisnis\src\Halaman\laporan;

use App\Tafio\bisnis\src\Models\kategori;
use App\Tafio\bisnis\src\Models\produkStok;
use App\Tafio\bisnis\src\Models\project;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class aset_produk extends Resource
{
    use tabs;
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

        $kategori = kategori::find(ambil('aset'));


$simpanan = 'omzetProduk_'.$pilihan."_".ambil('aset')."_".session('company')."_".session('cabang');

if (Cache::has($simpanan)) {
$ambil = Cache::get($simpanan);

}
else
{
$ambil=DB::table('project_details')
->selectRaw('produk_models.nama as namaProduk,produks.nama as varian,produks.id as id,month(projects.created_at) as bulan,sum(project_details.harga * jumlah) as omzetProduk') 
->join('produks','produk_id','=','produks.id')
->join('produk_models','produk_model_id','=','produk_models.id')
->join('projects','project_id','=','projects.id')
->where('kategori_id', ambil('aset'))
->where('produk_models.jual', 1)
->where('project_details.company_id', session('company'))
->whereYear('projects.created_at', $pilihan)
->groupBy('produks.id','bulan')
->orderBy('produk_model_id')->orderBy('produks.id')->orderBy('bulan');

            if (session('cabang') != 0) 
                $ambil->where('cabang_id', session('cabang'));
            $ambil=$ambil->get();

 Cache::put($simpanan, $ambil, 86400);
}





        // $ambil = produk::selectRaw('produks.id, produk_models.nama as namaProduk,produks.nama as varian,month(tanggal) as bulan
        // ,sum(omzet) as omzetProduk')->
        //     where('produks.company_id', session('company'))->
        //     where('produk_models.jual', 1)->
        //     where('kategori_id', ambil('aset'))->
        //     join('produk_models', 'produk_models.id', '=', 'produks.produk_model_id')->
        //     leftJoin('produk_omzets', 'produk_omzets.produk_id', '=', 'produks.id')->
        //     whereYear('tanggal', $pilihan)->
        //     groupBy('produks.id','bulan')->
        //     orderBy('produk_model_id')->orderBy('produks.id')->orderBy('bulan');
            
        //     if (session('cabang') != 0) 
        //         $ambil->where('cabang_id', session('cabang'));
            
        //     $ambil=$ambil->get();


$yy=produkStok::lastStok()->where('kategori_id',ambil('aset'));

            if (session('cabang') != 0) 
                $yy->where('cabang_id', session('cabang'));
            $yy=$yy->get();

$produk=null;
$totalAset=0;

            foreach ($yy as $row) {
if(empty($aset[$row->produk_id]))
$aset[$row->produk_id]=0;

$aset[$row->produk_id]+=$row->saldo*$row->hpp;
        }

        foreach ($ambil as $row) {

// dd($row);

if($produk!=$row->id)
{
$hasil[$row->id]=(object)['id'=>$row->id];
$totalAset+=$hasil[$row->id]->aset=$aset[$row->id]??0;
}


$xx=$row->omzetProduk??0;
$hasil[$row->id]->{'omzet'.$row->bulan}=$xx;
$total[$row->bulan]=($total[$row->bulan]??0)+$xx;
$hasil[$row->id]->varian=$row->varian;
$hasil[$row->id]->namaProduk=$row->namaProduk;


$produk=$row->id;
}

$hasil['xxx']=(object)['id'=>'xxx','namaProduk'=>'<h3>total','aset'=>$totalAset];
        foreach ($bulans as $i => $bulan) {
$hasil['xxx']->{'omzet'.$i} = $total[$i]??0;
}

            $xx=collect($hasil);

        $this->halaman = (new crud)->make()
        ->linkTabs(index:$this->tab_aset())
        ->projectlist($xx)
        ->judul($kategori->nama, 'produk')
        ->route('index');

        $this->fields = [
            (new select)->make('tahun')->search('noField', 'noQuery')->options($tahun)->default($skr),
            (new noForm)->make('namaProduk'),
            (new noForm)->make('varian'),
            (new noForm)->make('aset')->uang()];
        // (new noForm)->make('omzet')->uang(),
            foreach ($bulans as $i => $bulan) {
                $this->fields[] = (new noForm)->make('omzet' . $i)->judul($bulan)->uang();
            }

    }
}
