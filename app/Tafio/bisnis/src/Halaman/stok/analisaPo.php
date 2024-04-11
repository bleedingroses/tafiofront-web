<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\statis;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\kategori;
use App\Tafio\bisnis\src\Models\project;
use App\Tafio\bisnis\src\Models\omzet;
use App\Tafio\bisnis\src\Models\produk;
use App\Tafio\bisnis\src\Models\produkStok;
use App\Tafio\bisnis\src\Models\produkModel;
use App\Tafio\bisnis\src\Library\tabs;
use Carbon\Carbon;

class analisaPo extends Resource
{    
    use tabs;
    public function config()
    {


/*
konsep:
1. hitung kebutuhan harian, dari history 3 bulan terakhir
2. waktu po udah diset di data supplier
3. stok minimal 1.5 X waktu po * kebutuhan harian
4. kalo kurang dari stok minimal, muncul alarm kekurangan
5. kalo ada bbrp kali po, dalam 1 produk, kekurangan diitung berdasarkan jumlah
   tiap kedatangan dikurangi kebutuhan harian
*/


$ambil=produk::analisaStok()->selectRaw('data_kontaks.id as supplier_id,data_kontaks.nama as supplier,produks.id as id,waktu_po,produks.id, produk_model_id,produks.nama as varian,produk_models.nama as produk')->
whereNotNull('data_kontaks.waktu_po')->
whereNull('abaikan')->
get();
$hasil=false;


$yy=produkStok::lastStok()->get();
        foreach ($yy as $row) {
            
if(empty($stok[$row->produk_id]))
$stok[$row->produk_id]=0;
$stok[$row->produk_id]+=$row->saldo;
        }




foreach($ambil as $baris=>$produk)
{
$produk->stokTotal=$stok[$produk->id]??0;
if($produk->stokTotal>=$produk->stokMin)
$ambil->forget($baris);
else
{

$produk->abaikan="
<form action=
".url('bisnis/stok/analisaPo/'.$produk->produk_model_id)."
method=post >
     <input type=hidden name=_token value='".csrf_token()."'>
     <input type=hidden name=abaikan value=1>
                <input type=hidden name=_method value=PATCH />
    <button  class='btn btn-xs btn-rounded btn-danger pull-left m-l-5' 
    onclick='return confirm(\"Anda yakin produk ini akan diabaikan?\")'>
    abaikan</button></form>
";



$pos=$produk->poDetail()->proses()->get();

$total=null;
$kedatangan_sebelumnya=carbon::now();
$sisa=$lebihan=$produk->stokTotal/$produk->penjualanHarian;
$sisa_hari=$produk->waktu_po;

$awal=true;

foreach($pos as $po)
{
$kedatangan=Carbon::createFromFormat('Y-m-d', $po->tglKedatangan);
$produk->kedatangan.=$kedatangan->format('d M').'<br>';

if($kedatangan->isFuture())
{



$kurang_hari=$kedatangan->diffInDays($kedatangan_sebelumnya);
$sisa_hari-=$kurang_hari;


$lebihan-=$kurang_hari;
if($lebihan<0)
{ 

    if($awal)
    {
        if($sisa>0)
  $produk->telat="<font color=red>".Carbon::now()->addDays($sisa)->format('d M');  
else
  $produk->telat="<font color=red>habis";  

}
    $lebihan=0;
}
$kedatangan_sebelumnya=$kedatangan;
}

$jumlah_dateng=$po->jumlah-$po->jumlahKedatangan;
$lebihan+= $jumlah_dateng/$produk->penjualanHarian;

$produk->sudahPo.=$jumlah_dateng.'<br>';

$awal=false;
}




///////////////// jumlah po, brapa kalinya stok minimal
$pengali_po=2;



$kekurangan=(($pengali_po*$produk->waktu_po)-$lebihan)*$produk->penjualanHarian;
$produk->lebihan=$lebihan;


if($kekurangan>0)
{


$produk->sebelum=$kedatangan_sebelumnya->addDays(floor($lebihan-$produk->waktu_po));


if($produk->sebelum->isFuture())
$produk->tglSebelum=$produk->sebelum->format('d M');
else
{
$telat=carbon::now()->diffInDays($produk->sebelum);


$produk->tglSebelum='<h5><font color=red>telat<br>'.$telat." hari";
}
$produk->kekurangan=ceil($kekurangan);

}
// else
// $ambil->forget($baris);

}

$hasil=$ambil->sortByDesc('sebelum');

}


        $this->halaman = (new crud)->make()->projectlist($hasil)->judul('analisa PO')
        ->route('index','edit')->noEditButton()
            ->linkTabs(index:$this->tab_analisa());
 
            
        $this->fields = [
            (new noForm)->make('produkModel->kategori->nama')->judul('kategori'),            
            (new noForm)->make('produk'),            
            (new noForm)->make('varian'),            
            (new noForm)->make('supplier')->linkPopUp('bisnis/data/kontak/{supplier_id}'),            
            (new noForm)->make('waktu_po')->judul('waktu<Br>po'),            
          (new noForm)->make('penjualanHarian')->judul('selling<Br>harian'),
          (new noForm)->make('stokTotal')->judul('stok<br>skr'),
          (new noForm)->make('telat')->judul('hbs <br>tgl'),
          (new noForm)->make('sudahPo')->judul('sudah<br>po'),
          (new noForm)->make('sudahProduksi')->judul('sudah<br>produksi'),
          (new noForm)->make('kedatangan')->judul('datang<br>tgl'),
          (new noForm)->make('kekurangan')->judul('harus<br>po lg'),
          (new noForm)->make('tglSebelum')->judul('sblm<br>tgl'),
          (new noForm)->make('abaikan'),
        
        ];
            // (new noForm)->make('omzet')->uang(),



        
    }

public function update_proses($model)
{


$abaikan=request()->abaikan;

if($abaikan==0)
$abaikan=null;

produkModel::find(ambil('analisaPo'))->update(['abaikan'=>$abaikan]);


}



}

