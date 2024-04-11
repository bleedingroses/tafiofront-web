<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\produkModel;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;


class produkModel_produk extends Resource
{
    use tabs;
    public function config()
    {

        $this->halaman = (new crud)->make()
        ->linkTabs(index:$this->tab_produkModel())
        ->route('index','edit','create')
        ->popup();


        $this->fields = [
            (new noForm)->make('id')->judul('sku'),
            (new text)->make('nama'),
            (new select)->make('status')->options([1 => 'aktif', 0 => 'tidak aktif'])->default('aktif'),
            (new noForm)->make('hpp'),
        ];
    }
}
