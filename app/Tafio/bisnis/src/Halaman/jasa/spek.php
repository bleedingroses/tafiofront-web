<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;

class spek extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make('spek')
        ->noPaginate();

        $this->fields = [
            (new text)->make('nama')->sortable()->validate('required'),
        ];

    }
}
