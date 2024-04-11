<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\po;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class po_deposit extends resource
{
    public function config()
    {
        $this->akunDetail = akunDetail::kas()->pluck('nama', 'id');
        $this->halaman = (new crud)->make()->route('create')->popup()->redirect('bisnis/stok/po/' . ambil("po"));
        $this->po = po::find(ambil('po'));

        $this->fields = [
            (new text)->make('jenis')->default('deposit')->disabled(),
            (new number)->make('total')->linkPopup('bisnis/data/keuangan/{id}/keuanganDetail')->validate('required'),
            (new text)->make('ket'),
            (new select)->make('akun_detail_id')->indexField('akunDetail->nama')->options($this->akunDetail)->validate('required')->judul('dari kas'),
            (new hidden)->make('detail_id')->default(ambil('po')),
            (new hidden)->make('kontak_id')->default($this->po->kontak->id),
        ];
    }

    public function after_store($model)
    {
        $model->akunDetail->bukuBesar()->create([
            'ket' => "beri deposit ke " . $this->po->kontak->namaLengkap,
            'kredit' => request()->total,
            'debet' => 0,
            'detail_id' => $this->po->id,
            'kode' => 'dpt',
        ]);
    }

}
