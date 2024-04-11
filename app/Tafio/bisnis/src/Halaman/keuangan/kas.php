<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Models\akunKategori;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;

class kas extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make('akunDetail')
        ->scope('semuaKas')
        ->noPaginate()
        ->orderBy('akun_kategori_id')
        ->route('index')
        ->judul('kas')
        ->noEditButton();

        $this->fields = [
            (new noForm)->make('akunKategori->nama'),
            (new noForm)->make('no_akun')->judul('no akun'),
            (new noForm)->make('nama')->link('bisnis/keuangan/kas/{id}/bukuBesar')->sortable(),
            (new noForm)->make('saldo')->uang(),
        ];
    }
}
