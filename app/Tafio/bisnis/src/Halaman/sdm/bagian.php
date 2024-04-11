<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;

class bagian extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index','show');

        $this->fields = [
            (new noForm)->make('id')->sortable(),
            (new text)->make('nama')->validate('required'),
            (new number)->make('grade')->validate('required'),
        ];
    }
}
