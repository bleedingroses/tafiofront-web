<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;

class satuan extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()->route('index','edit','create');
        
        $this->fields = [
            (new text)->make('nama')->link('bisnis/data/kategoriUtama/{id}/kategori'),
        ];
    }
}
