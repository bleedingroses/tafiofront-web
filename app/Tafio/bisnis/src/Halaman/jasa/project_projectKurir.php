<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\crud;

class project_projectKurir extends Resource
{
    use tabs;

    public function config()
    {
        $this->halaman = (new crud)->make()->route('index', 'create', 'edit')->linkTabs(index:$this->tab_project())->popUp();

        $this->fields = [
            (new date)->make('tanggal')->validate('required'),
            (new text)->make('nomor'),
            (new number)->make('jumlah')->validate('required'),
            (new text)->make('pengantar')->validate('required'),
            (new text)->make('penerima')->validate('required'),
            (new number)->make('perkiraan'),
            (new textarea)->make('keterangan'),
        ];
    }

}
