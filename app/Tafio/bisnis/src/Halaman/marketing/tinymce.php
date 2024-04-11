<?php

namespace App\Tafio\bisnis\src\Halaman\marketing;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\custom;

class tinymce extends Resource
{

    public function config()
    {
        $this->halaman=(new custom)->make()->customView("custom.marketing.tinymce")->route('index');
    }

}
