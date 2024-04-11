<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\statis;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\kategori;
use App\Tafio\bisnis\src\Models\project;
use App\Tafio\bisnis\src\Models\omzet;
use App\Tafio\bisnis\src\Models\produk;
use App\Tafio\bisnis\src\Models\projectDetail;
use App\Tafio\bisnis\src\Library\tabs;
use Carbon\Carbon;

class analisaNonAktif extends Resource
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


$ambil=produk::analisaStok()->groupBy('produk_models.id')->
where(function ($q) {
return $q->whereNull('waktu_po')->orWhere('abaikan',1);
})
->
get();

        $this->halaman = (new crud)->make()->projectlist($ambil)->judul('analisa PO tdk aktif')
        ->route('index')
            ->linkTabs(index:$this->tab_analisa());
        

$aktifkan="
<form action=".url('bisnis/stok/analisaPoLagi')."/{produk_model_id}
method=post>
     <input type=hidden name=_token value='".csrf_token()."'>
     <input type=hidden name=abaikan value=0>
                <input type=hidden name=_method value=PATCH />
    <button  class='btn btn-xs btn-rounded btn-success pull-left m-l-5' 
    onclick='return confirm(\"Anda yakin produk ini akan diaktifkan?\")'>
    aktifkan</button></form>
";



        $this->fields = [
            (new noForm)->make('produkModel->kategori->nama')->judul('kategori'),            
            (new noForm)->make('produkModel->nama')->judul('produk')->linkPopup('bisnis/data/kategoriUtama/{kategori_utama_id}/kategori/{produkModel->kategori_id}/produkModel/{produk_model_id}'),            
            (new noForm)->make('produkModel->supplier->waktu_po')->judul('waktu po'),            
            (new toggle)->make('abaikan')->judul('diabaikan'),            
            (new noForm)->make('produkModel->supplier->namaLengkap')->linkPopUp('bisnis/data/kontak/{supplier_id}'),            
            (new noForm)->make('aktifkan')->value($aktifkan),            
        
        ];
            // (new noForm)->make('omzet')->uang(),



        
    }

}

