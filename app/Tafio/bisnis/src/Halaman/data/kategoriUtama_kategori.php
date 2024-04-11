<?php

namespace App\Tafio\bisnis\src\Halaman\data;
use  App\Tafio\bisnis\src\Models\kategoriUtama;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\select;    

class kategoriUtama_kategori extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index','edit', 'create')
        ->orderBy(id:'asc')
        ->noPaginate();
        
        $this->fields = [
            (new text)->make('nama')->link('bisnis/data/kategoriUtama/{kategori_utama_id}/kategori/{id}/produkModel')->validate("required"),
            (new select)->make('kategori_utama_id')->display('edit')->options(kategoriUtama::get()->pluck('nama','id'))->validate('required')->default(ambil("kategoriUtama")),            
            // (new toggle)->make('web')->default('1'),
        ];
    }
}
