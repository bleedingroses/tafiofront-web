<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class arsipPo extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make('po')
            ->route('index','show')
            ->scope('finish')
            ->judul('arsip po')
            ->linkTabs(index:$this->tab_po());

        $this->fields = [
            $this->fieldTanggal()->judul('tanggal po'),
            
            (new noForm)->make('kontak->namaLengkap'),
            (new noForm)->make('produk')->linkPopUp('bisnis/stok/po/{id}'),
            (new noForm)->make('tglKedatangan')->judul('perkiraan datang'),
            (new number)->make('status'),
        ];  
    }
}
