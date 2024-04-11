<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Field\color;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class ar extends Resource
{
    use templateFields;
    public function config()
    {
        $member = member::doesntHave('ar')->with('kontak')->aktif()->get();
        foreach ($member as $value) {
            $members[$value->id] = $value->kontak->namaLengkap;
        }
        $this->halaman = (new crud)->make();

        $this->fields = [
            (new noForm)->make('member->kontak->namaLengkap')->displayFront(),
            (new select)->make('member_id')->indexField('member->namaLengkap')->options($members)->formCreateOnly(),
            (new text)->make('kode')->validate('required')->displayFront(),
            (new color)->make('warna')->validate('required')->displayFront(),
            (new gambar)->make('ttd')->validate('image|max:20000')->displayFront(),
            $this->fieldCabang()

        ];


    }
}
