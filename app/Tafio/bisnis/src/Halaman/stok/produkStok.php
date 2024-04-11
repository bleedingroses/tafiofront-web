<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\cabang;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\produksi as modelProduksi;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class produkStok extends Resource
{
    use templateFields,tabs;
    public function config()
    {
        $this->halaman = (new crud)->make()->route('index')
        ->scope('opname')
        ->judul('stok opname');

        $this->fields = [
            $this->fieldTanggal()->display('index'),
            (new noForm)->make('cabang->nama'),
            (new autocomplete)->make('produk->namaLengkap')->namaField('produk_id')->judul('produk')->display('index')->model('bisnis.produk')->search()->scope('jual'),
            (new number)->make('tambah')->judul('bertambah'),
            (new noForm)->make('kurang')->judul('berkurang'),
            (new noForm)->make('keterangan'),
            (new noForm)->make('user')->judul('user'),
        ];

  

        
    }
}
