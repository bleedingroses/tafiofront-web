<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Models\authlevel;
use App\Tafio\bisnis\src\Models\lembur;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\crud;

class member_lembur extends Resource
{
    public function config()
    {
        $member = ambil("member");

        $this->halaman=(new crud)->make('member_lembur')      
        ->judul(...['pegawai aktif', 'lembur'])
        ->route('edit','index','create')
        ->popup();

        $this->fields = [
            (new hidden)->make('member_id')->default($member),
            (new hidden)->make('tahun')->default(date('Y'))->displayFront(),
            (new select)->make('bulan')->validate('required')->options(bulan())->displayFront(),
            (new number)->make('jam')->validate('required')->displayFront(),
            (new textarea)->make('keterangan')->displayFront(),
            (new hidden)->make('dibayar')->default('belum')->displayFront(),
            (new noForm)->make('status')->displayFront(),
        ];
    }

}
