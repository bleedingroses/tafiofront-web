<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\chart;

class omzetBulanan extends Resource
{

    public function config()
    {
        $this->halaman=(new chart)->make('project')      
        ->judul('omzet per bulan')
        ->scope('omzetBulanan')
        ->jenisChart('AreaChart')
        ->noTable();

        if (session('cabang') != 0) {
            $this->halaman->scope('omzetBulanan',percabang:[session('cabang')]);
        }

        $this->fields = [
            (new noForm)->make('bulanTahun')->judul('bulan'),
            (new noForm)->make('omzet'),
        ];
    }

}
