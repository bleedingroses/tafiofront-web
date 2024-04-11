<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\color;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;

class cabang extends Resource
{

    public function config()
    {
        $this->halaman = (new crud)->make('cabang');

        $this->fields = [
            (new text)->make('nama')->sortable()->validate('required')->linkShow()->search(),
            (new text)->make('kode')->validate('required'),
            (new color)->make('warna'),
            (new text)->make('rek'),
            (new textarea)->make('alamat'),
        ];
    }

}
