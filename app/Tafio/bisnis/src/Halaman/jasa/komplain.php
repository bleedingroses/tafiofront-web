<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;

class komplain extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make('projectKomplain')
        ->route('index', 'edit');

        $this->fields = [
            (new noForm)->make('project->kontak->namaLengkap')->judul('konsumen'),
            (new noForm)->make('projectDetail->produk->namaLengkap')->judul('produk'),
            (new text)->make('bagian'),
            (new text)->make('komplain'),
            (new text)->make('solusi'),
        ];
    }

}
