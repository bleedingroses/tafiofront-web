<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Models\authlevel;
use App\Tafio\bisnis\src\Models\cuti;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;

class member_cuti extends Resource
{
    public function config()
    {
        $member = ambil("member");

        $this->halaman=(new crud)->make('member_cuti')      
        ->judul(...['pegawai aktif', 'cuti'])
        ->popup();

        $this->fields = [
            (new hidden)->make('member_id')->default($member),
            (new date)->make('tanggal')->validate('required'),
            (new text)->make('keterangan'),
            (new select)->make('cuti')->judul('ijin/cuti')->options(['1' => 'cuti', '0' => 'ijin'])->validate('required')->search(),
        ];
    }
}
