<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use App\Tafio\bisnis\src\Library\templateFields;
use Tafio\core\src\Library\vue;
use App\Tafio\bisnis\src\Models\ar;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\email;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\manySelect;

class kontak extends Resource
{

        use templateFields;
    public function config()
    { 

        $scope = ['konsumen'];

        $this->halaman = (new crud)->make()
            ->route('index', 'show', 'edit', 'create')
            ->adaNomor()
            ->adachat();

        if (session('cabang') != 0) {
            $scope['percabang'] = [session('cabang')];
        }

        if (request()->pembayaran == 1) {
            $scope[] = 'belumLunas';
        }
        
        $this->halaman->scope = $scope;

        $this->fields = [
            (new text)->make('kontak')->search('noField', 'noQuery')->judul('perusahaan / contact person :'),
            (new text)->make('nama')->displayFront()->sortable()->linkShow()->validate('required_without:perusahaan')->formInfo('wajib diisi salah satu nama / perusahaan'),
            (new text)->make('perusahaan')->displayFront()->validate('required_without:nama')->sortable()->linkShow()->formInfo('wajib diisi salah satu nama / perusahaan'),
            (new text)->make('noTelp')->displayFront()->validate('required')->search(),
            (new email)->make('email'),
            (new textarea)->make('alamat'),
            $this->fieldTanggal()->judul('bergabung tgl'),
            (new manySelect)->make('jenis')->search()->noModel()->options(['konsumen', 'supplier', 'marketplace','lainnya'])->default('konsumen')->displayFront(),
            (new toggle)->make('pembayaran')->options('semua', 'yg blm lunas')->judul('pembayaran')->search('noField', 'noQuery'),
            (new noForm)->make('saldo')->judul('total piutang')->displayFront()->uang()->linkPopUp('bisnis/data/kontak/{id}/keuangan'),
            (new textarea)->make('ket'),
            (new number)->make('waktu_po')->judul('waktu po')->vue((new vue)->type('show')->dependFields(jenis:['supplier'])),
            $this->fieldCabang()
        ];
        if (session('totalAr') >= 1) {
            $dataAr = ar::get();
            $this->fields[] = (new select)->make('ar_id')->displayFront()->options($dataAr->pluck('nama', 'id'));
        }



    }

    public function before_store()
    {
        if (!request()->konsumen and !request()->supplier and !request()->lainnya and !request()->marketplace) {
            request()->validate(['konsumen' => 'required']);
        }

    }

    public function before_update($xx)
    {
        if (request()->konsumen != 1 and request()->supplier != 1 and request()->lainnya != 1 and request()->marketplace!=1) {
            request()->validate(['konsumen' => 'accepted']);
        }

    }

}
