<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\chart;

class omzet extends Resource
{
    public function config()
    {
        $this->halaman=(new chart)->make('project')      
        ->judul('omzet per tahun')
        ->scope('omzettahun')->noTable();

        if (session('cabang') != 0) {
            $this->halaman->scope('omzettahun',percabang:[session('cabang')]);
        }

        $this->fields = [
            (new noForm)->make('year'),
            (new noForm)->make('sum')->judul('omzet'),
        ];
    }
}
