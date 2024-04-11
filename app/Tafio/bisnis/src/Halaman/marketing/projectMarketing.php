<?php

namespace App\Tafio\bisnis\src\Halaman\marketing;
use App\Tafio\bisnis\src\Library\templateFields;

use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\projectMarketing as modelMarketing;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class projectMarketing extends Resource
{

        use templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make()
            ->route('index', 'show', 'edit', 'create')
            ->adachat()
            ->noCreateButton();

        $fields = [
            $this->fieldTanggal()->displayFront(), 
            $this->fieldKonsumen()->search()->displayFront(),
        ];

        if ($this->method == 'show' or $this->method == 'edit') {
            $marketing = modelMarketing::find(ambil('projectMarketing'));
            if (!$marketing->kontak_id) {
                $fields[1] = (new text)->make('perusahaan');
            }

        } else if ($this->method == 'create' and request()->calon == 1) {
            $fields[1] = (new text)->make('perusahaan');
        } else if ($this->method == 'index') {
            $fields[] = (new noForm)->make('perusahaan')->displayFront();
        }

        $this->fields = array_merge($fields, [
            (new text)->make('pertanyaan')->judul('rencana order')->displayFront(),
            (new text)->make('hasil')->judul('hasil follow up')->displayFront(),
            (new noForm)->make('updated_at')->judul('terakhir follow up')->tanggal('d-m-Y')->displayFront(),
            (new date)->make('followup_next')->judul('difollow up lagi')->displayFront(),
            (new text)->make('via'),
            (new select)->make('status')->options(['proses' => 'proses', 'batal' => 'batal', 'order' => 'order'])->displayFront()->validate('required')->linkShow(),
            (new select)->make('ar_id')->options(ar::get()->pluck('nama', 'id'))->search()->validate('required'),
        ]);
    }

}
