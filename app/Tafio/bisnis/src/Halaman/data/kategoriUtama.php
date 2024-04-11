<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\manySelect;

class kategoriUtama extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()->route('index','edit','create');
        
        $this->fields = [
            (new text)->make('nama')->link('bisnis/data/kategoriUtama/{id}/kategori'),
            (new manySelect)->make('jenis')->noModel()->options(['jual', 'beli'])->default('jual'),
            (new toggle)->make('stok')->default('ya')->judul('pakai stok'),
            (new toggle)->make('web')->default('ya'),
        ];
    }
}
