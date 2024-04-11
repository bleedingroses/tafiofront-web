<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\produk;
use App\Tafio\bisnis\src\Models\projectDetail;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\statis;
use Tafio\core\src\Library\Halaman\crud;
class project_projectKomplain extends Resource
{
    use tabs;

    public function config()
    {
        $projectDetails = projectDetail::where('project_id', ambil("project"))->get();

        foreach ($projectDetails as $detail) {
            if(!$detail->komplain)
            $projecdetail[$detail->id] = $detail->produk->namaLengkap;
        }

        $this->halaman = (new crud)->make()->route('index', 'create', 'edit')->linkTabs(index:$this->tab_project())->popUp();

        $this->fields = [
            (new statis)->make('projectDetail->produk->namaLengkap')->judul('produk')->display('index','edit'),
            (new noForm)->make('projectDetail->tema')->judul('tema'),
            (new select)->make('project_detail_id')->judul('produk')->validate('required')->options($projecdetail ?? null)->display('create'),
            (new text)->make('bagian'),
            (new text)->make('komplain'),
            (new text)->make('solusi'),
        ];

    }
}
