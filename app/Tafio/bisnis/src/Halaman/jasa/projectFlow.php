<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Field\color;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\grup;

class projectFlow extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->judul('Produksi')
        ->orderBy(urutan:'asc')
        ->noPaginate();

        $this->fields = [
            (new number)->make('urutan'),
            (new text)->make('nama')->validate('required'),
            (new color)->make('warna')->validate('required'),
            (new select)->make('grup_id')->options(grup::get()->pluck('nama','id'))->validate('required')->sortable(),
        ];
    }
}
