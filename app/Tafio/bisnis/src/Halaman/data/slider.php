<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Halaman\crud;

class slider extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()->route('index','edit','create');
        
        $this->fields = [
            (new text)->make('nama'),
            (new gambar)->make('big_img')->judul('gambar website'),
            (new gambar)->make('mobile_img')->judul('gambar mobile'),
        ];
    }
}
