<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\color;
use Tafio\core\src\Library\Halaman\crud;

class process extends Resource
{

    public function config()
    {
        $this->halaman = (new crud)->make('process');
        
        $this->fields =[
            (new text)->make('nama'),
            (new color)->make('warna'),
        ];
    }

}
