<?php

namespace App\Tafio\bisnis\src\Halaman\laporan;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Library\templateFields;
class tunjangan extends Resource
{
    use templateFields;   
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index','show')
        ->orderBy(created_at:'desc');

        $this->fields = [
            $this->fieldTanggal2()->displayFront()->search()->sortable(),
            (new noForm)->make('member->kontak->namaLengkap')->displayFront(),
            (new noForm)->make('ket')->displayFront(),
            (new noForm)->make('jumlah')->displayFront()->judul('tunjangan')->uang(),
        ];
    }
}
