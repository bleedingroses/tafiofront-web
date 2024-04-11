<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use DB;
use Tafio\core\src\Library\vue;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\produk;
use App\Tafio\bisnis\src\Models\satuan;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\kategori;
use App\Tafio\bisnis\src\Models\produkStok;
use Tafio\core\src\Library\Field\textarea;
use App\Tafio\bisnis\src\Models\produkModel;
use Tafio\core\src\Library\Field\manySelect;
use App\Tafio\bisnis\src\Models\kategoriUtama;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Controllers\Traits\prosesGambar;
use App\Tafio\bisnis\src\Library\templateFields;

class kategoriUtama_kategori_produkModel extends Resource
{
    use tabs,prosesGambar,templateFields;
    public function config()
    {             
        $satuan = satuan::get();
        $utama = kategoriUtama::find(ambil("kategoriUtama"));
        $jual = $utama->jual === 1 ? 'jual' : '';
        $beli = $utama->beli === 1 ? 'beli' : '';
        $stok = $utama->stok === 1 ? '1' : '';

        $this->halaman = (new crud)->make()
        ->linkTabs(show:$this->tab_produkModel(),index:$this->tab_produk())
        ->route('index','create','show','edit')
        ->judul('kategori utama', 'kategori', 'produk')
        ->noPaginate();
        
        if($this->method=='index')
        {
            $projectList=produkModel::leftJoin(DB::raw("(select produks.id as produkId, nama as varian, hpp, produk_model_id, status
            from `produks`)as A"),"A.produk_model_id", "=", "produk_models.id")
            ->where('kategori_id',ambil('kategori'))->where('status', 1)->get();


$stok=[];


$yy=produkStok::lastStok()->where('kategori_id',ambil('kategori'))->get();


        foreach ($yy as $row) {
$stok[$row->produk_id][$row->cabang_id]=$row->saldo;
        }




            $id="";        
            foreach($projectList as $key=>$hasil)
            {
                $hasil->beli=123; 
                $id_skr=$hasil->produk_model_id;
            if($id==$id_skr)
            $hasil->harga=$hasil->harga_mp=$hasil->satuan=$hasil->gambar=$hasil->nama='';
            // $projectList->forget($key);
            foreach (session('totalCabang') as $idcabang=>$item) {
            $hasil->{"stok".$idcabang}=$stok[$hasil->produkId][$idcabang]??0;
            }
            
                $id=$id_skr;
            
        };
            $this->halaman->projectList($projectList);
        }
        $this->fields = [
            (new noForm)->make('produkId')->judul('sku')->displayFront()->display('index'),
            (new gambar)->make('gambar')->displayFront(),
            (new text)->make('nama')->linkShow()->displayFront()->validate('required'),
            (new noForm)->make('varian')->displayFront()->display('index'),
            (new select)->make('kategori_id')->display('edit')->options(kategori::where('kategori_utama_id',ambil('kategoriUtama'))->get()->pluck('nama','id'))->validate('required')->default(ambil("kategori")),
            (new select)->make('satuan')->options($satuan->pluck('nama', 'nama'))->displayFront(),
            (new noForm)->make('beli')->judul('harga <br>beli')->displayFront()->linkPopUp('bisnis/data/produk/{produkId}/history'),
            (new manySelect)->make('jenis')->noModel()->options(['jual', 'beli', 'stok', 'produksi','web'])->default($jual,$beli,$stok),
            (new number)->make('harga')->judul('harga<br>jual')->displayFront()->vue((new vue)->type('show')->dependFields(jenis:['jual'])),
            (new autocomplete)->make('supplier->namaLengkap')->judul('supplier')->model('bisnis.kontak')->namaField('supplier_id')->scope('supplier')
            ->vue((new vue)->type('show')->dependFields(jenis:['beli'])),
            (new textarea)->make('deskripsi'),
            (new noForm)->make('hpp')->displayFront()->display('index')->uang()
        ];

        if($this->method=='index'){
            foreach (session('totalCabang') as $idcabang=>$item) {
                $this->fields[] = (new noForm)->make('stok'.$idcabang)->judul('stok<Br>'.$item)->displayFront()
                ->linkPopUp('bisnis/data/produk/{produkId}/cabang/'.$idcabang.'/produkStok');
            }
        }

        if (request()->jenis == 'hutang') {
            # code...
        }
      

    }

    public function before_store()
    {
        if(request()->input('jual')==1){
            request()->validate(['harga'=>'required']);
        }
    }

    public function after_store($hasil)
    {
        $varian['status'] = 1;
        $varian['produk_model_id'] = $hasil->id;
        produk::create($varian);
    }

    public function before_update($hasil)
    {
        if(request()->input('jual')==1){
            request()->validate(['harga'=>'required']);
        }
    }
}
