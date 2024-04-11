<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Models\cabang;
use Tafio\core\src\Library\Halaman\custom;

class slipGaji extends Resource
{
    public function config()
    {
        $this->halaman=(new custom)->make()->customView("custom.sdm.slipgaji")->route('index')->popup();

        $this->logo = moduleConfig('core', 'logo');
        if (session('cabang') == 0) {
            $cabang = cabang::first();
            $this->alamatKantor = $cabang->alamat;
        } else {
            $cabang = cabang::find(session('cabang'));
            $this->alamatKantor = $cabang->alamat;
        }
    }
}
