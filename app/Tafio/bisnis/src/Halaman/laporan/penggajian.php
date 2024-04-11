<?php

namespace App\Tafio\bisnis\src\Halaman\laporan;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Library\templateFields;
class penggajian extends Resource
{
    use templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index','show');
        
        $this->fields = [
            $this->fieldTanggal2()->search()->sortable(),
            (new noForm)->make('member->kontak->namaLengkap')->judul('pegawai'),
            (new noForm)->make('pokok')->uang(),            
            (new noForm)->make('jam_lembur')->judul('jam lembur'),
            (new noForm)->make('lembur')->uang(),
            (new noForm)->make('kasbon')->judul('potong kasbon')->uang(),
            (new noForm)->make('bonus')->uang(),
            (new noForm)->make('total')->uang(),
            (new noForm)->make('slipGaji')->value('<button class="btn btn-rounded btn-info btn-sm">slip gaji</button>')->linkPopUp('bisnis/sdm/slipGaji?idSLipGaji={id}'),
        ];
    }
}
