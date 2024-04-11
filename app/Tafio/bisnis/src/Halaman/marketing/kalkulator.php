<?php

namespace App\Tafio\bisnis\src\Halaman\marketing;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\custom;

class kalkulator extends Resource
{
    public function config()
    {
        $this->halaman=(new custom)->make()->customView("custom.marketing.kalkulator");
    }

}
