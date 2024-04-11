<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use App\Tafio\bisnis\src\Models\produksi as modelProduksi;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Models\produksi;
use App\Tafio\bisnis\src\Library\templateFields;

class produksi_bahan extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $produksi = modelProduksi::find(ambil('produksi'));
        $this->halaman = (new crud)->make()
            ->route( 'create', 'destroy')
            ->popup()
            ->redirect('bisnis/stok/produksi/' . ambil("produksi"));
        $this->fields = [
            $this->fieldTanggal(),
            (new autocomplete)->make('namaLengkap')->display('create')->judul('produk')->model('bisnis.produk')->namaField('produk_id')->scope('stok')->validate('required'),
            (new noForm)->make('produk->produkModel->nama'),
            (new number)->make('kurang')->judul('jumlah')->validate('required'),
            (new noForm)->make('produk->produkModel->harga')->judul('harga')->uang(),
            (new noForm)->make('total')->uang(),
            (new textarea)->make('keterangan'),
            (new hidden)->make('kode')->default('bahanProduksi'),
            (new hidden)->make('detail_id')->default(ambil('produksi')),
            (new hidden)->make('cabang_id')->default($produksi->cabang_id),
        ];
    }

    public function after_store($model)
    {
        $model->produksi->hitungBiaya();
    } 
    
    public function after_destroy($model)
    {
        $model->produksi->hitungBiaya();

    }
}
