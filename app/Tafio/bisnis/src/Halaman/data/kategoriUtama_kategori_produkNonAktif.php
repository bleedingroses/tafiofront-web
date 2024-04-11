<?php

namespace App\Tafio\bisnis\src\Halaman\data;
use Tafio\core\src\Library\vue;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\satuan;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\kategori;
use Tafio\core\src\Library\Field\textarea;
use App\Tafio\bisnis\src\Models\produkModel;
use Tafio\core\src\Library\Field\manySelect;
use App\Tafio\bisnis\src\Models\kategoriUtama;

class kategoriUtama_kategori_produkNonAktif extends Resource
{
    use tabs;
    public function config()
    {
        $satuan = satuan::get();
        $utama = kategoriUtama::find(ambil("kategoriUtama"));
        $jual = $utama->jual === 1 ? 'jual' : '';
        $beli = $utama->beli === 1 ? 'beli' : '';
        $stok = $utama->stok === 1 ? '1' : '';
        
        $this->halaman = (new crud)->make()
        ->linkTabs(index:$this->tab_produk())
        ->judul('kategori utama', 'kategori', 'produk')
        ->route('index','create','show','edit')
        ->noPaginate();

        if($this->method=='index')
        {
            $projectList=produkModel::leftJoin(DB::raw("(select id as produkId, nama as varian, hpp, produk_model_id, status
            from `produks`)as A"),"A.produk_model_id", "=", "produk_models.id")
            ->where('kategori_id',ambil('kategori'))->get()->where('status', 0);

            $this->id="";        
            $hasil = $projectList->map(function ( $item,  $key)  {
            $id_skr=$item->produk_model_id;
            if($this->id==$id_skr)
            $item->harga=$item->harga_mp=$item->satuan=$item->gambar=$item->nama='';
            $this->id=$id_skr;
            return $item;   
            });
            $this->halaman->projectList($hasil);
        }
        $this->fields = [
            (new noForm)->make('id')->judul('sku')->displayFront()->display('index'),
            (new gambar)->make('gambar')->displayFront(),
            (new text)->make('nama')->displayFront()->validate('required')->linkPopUp('bisnis/data/kategoriUtama/'.ambil('kategoriUtama').'/kategori/'.ambil('kategori').'/produkModel/{produk_model_id}'),
            (new noForm)->make('varian')->displayFront()->display('index')->linkPopUp('bisnis/data/produkModel/{produk_model_id}/produk/{produkId}/edit'),
            (new select)->make('kategori_id')->display('edit')->options(kategori::where('kategori_utama_id',ambil('kategoriUtama'))->get()->pluck('nama','id'))->validate('required')->default(ambil("kategori")),
            (new select)->make('satuan')->options($satuan->pluck('nama', 'nama'))->displayFront(),
            (new noForm)->make('harga_beli')->displayFront()->linkPopUp('bisnis/data/produk/{produkId}/history'),
            (new manySelect)->make('jenis')->noModel()->options(['jual', 'beli'])->default($jual,$beli),
            (new number)->make('harga')->judul('harga jual')->vue((new vue)->type('show')->dependFields(jenis:['jual'])),
            (new toggle)->make('stok')->default($stok)->judul('pakai stok'),
            (new toggle)->make('produksi')->default(1)->judul('pakai produksi'),
            (new textarea)->make('deskripsi'),
            (new noForm)->make('hpp')->displayFront()->display('index')->uang()
        ];
    }

}
