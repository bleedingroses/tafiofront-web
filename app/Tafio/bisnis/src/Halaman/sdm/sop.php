<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\richtext;

class sop extends Resource
{
    use tabs;
    public function config()
    {
        $jenis=request()->jenis??'peraturan';
        $this->halaman = (new crud)->make()
        ->route('index','show','create')->scope(jenis:[$jenis])->noCompany()->linkTabs(index:$this->tab_sop());

        $this->fields = [
            (new text)->make('judul')->validate('required')->linkShow()->display('index','create','edit'),
            (new text)->make('isi')->validate('required')->display('create','edit','show'),
            (new select)->make('bagian')->display('create')->options([
                'peraturan' => 'peraturan','marketing' => 'marketing','order' => 'order',
            ])->validate('required'),
        ];
    }
}
