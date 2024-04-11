<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;

class level extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index','show');

        $this->fields = [
            (new text)->make('nama')->validate('required'),
            (new number)->make('gaji_pokok')->validate('required')->uang()->judul('gaji pokok'),
            (new number)->make('komunikasi')->validate('required')->uang(),
            (new number)->make('transportasi')->validate('required')->uang(),
            (new number)->make('kehadiran')->validate('required')->uang(),
            (new number)->make('lama_kerja')->validate('required')->judul('lama kerja (%)'),
        ];
    }
}
