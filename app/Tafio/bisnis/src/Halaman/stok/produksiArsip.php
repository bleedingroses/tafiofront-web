<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\produksi as modelProduksi;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Halaman\custom;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class produksiArsip extends Resource
{
    use templateFields,tabs;
    public function config()
    {
        $this->halaman = (new crud)->make('produksi')
            ->route('index')
            ->scope('finish')
            ->judul('arsip produksi')
            ->linkTabs(index:$this->tab_produksi());

        $this->fields = [
            $this->fieldTanggal(),
            (new noForm)->make('produk->namaLengkap')->linkPopup('bisnis/stok/produksi/{id}'),
            (new noForm)->make('status')->display('show'),
            (new number)->make('target')->judul('target produksi')->uang()->validate('required'),
            (new noForm)->make('hasil')->judul('yg beres')->uang(),
            (new noForm)->make('biaya')->judul('total biaya')->uang(),
            (new noForm)->make('hpp')->uang(),
            (new textarea)->make('ket'),            
            (new noForm)->make('cabang->nama')
        ];
    }
}
