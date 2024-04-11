<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Models\projectDetail as modelProjectDetail;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class projectDetail extends Resource
{
    use templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make()
            ->judul('arsip produk')
            ->scope('search')
            ->route('index', 'edit')
            ->noEditButton();

        if ($this->method == 'update') {
            $detail = modelProjectDetail::find(ambil('projectDetail'));
            $this->halaman->redirect('bisnis/jasa/project/' . $detail->project_id);
        }

        $this->fields = [
            (new date)->make('project->created_at')->display('index')->tanggal('d-m-Y')->judul('tanggal'),
            (new autocomplete)->make('produk->namaLengkap')->model('bisnis.produk')->search()->namaField('produk_id')->scope('jual'),
            $this->fieldKonsumen()->display('index')->search('noField', 'noQuery'),
            (new noForm)->make('project->kontak->namaLengkap')->judul('konsumen'),
            (new text)->make('tema'),
            (new number)->make('jumlah'),
            (new number)->make('harga')->uang(),
            (new noForm)->make('total')->uang(),
            (new noForm)->make('listproduk')->judul('spesifikasi'),
            (new noForm)->make('projectFlow->nama')->judul('status'),

        ];
    }

}
