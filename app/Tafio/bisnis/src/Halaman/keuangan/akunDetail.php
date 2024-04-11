<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Models\akunKategori;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;

class akunDetail extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->orderBy('akun_kategori_id','no_akun')
        ->judul('akun')
        ->noPaginate();

        $this->fields = [
            (new noForm)->make('no_akun')->judul('no akun'),
            (new select)->make('akun_kategori_id')->indexField('akunKategori->nama')->judul('kategori')->options(akunKategori::get()->pluck('nama', 'id'))->validate('required'),
            (new text)->make('nama')->validate('required')->sortable()->search(),
            (new noForm)->make('saldo')->uang(),
        ];

    }
}
