<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Models\kontakKeuangan;
use App\Tafio\bisnis\src\Models\kontak;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class keuangan_keuanganDetail extends Resource
{ 
    use templateFields;

    public function config()
    {
        $this->akunDetail = akunDetail::kas()->pluck('nama', 'id');

        $this->keuangan = $keuangan = kontakKeuangan::find(ambil('keuangan'));

        $route = ['index'];

        if ($keuangan->kekurangan != 0) {
            $route[] = 'create';
        }

        $this->halaman = (new crud)->make('kontakKeuangan_keuanganDetail')
            ->judul('', $keuangan->jenis . ' ' . $keuangan->kontak->nama)
            ->route(...$route)
            ->popup()
            ->renameButtonTambah('pembayaran')
            ->infoIndex(...[
                'total' => ['icon' => 'user', 'isi' => $keuangan->total],
                'kekurangan' => ['isi' => $keuangan->kekurangan],
            ]);

        if ($keuangan->jenis == 'hutang' or $keuangan->jenis == 'belanja') {$judul = "bayar dari rek";
            $judul2 = "uang yg dibayarkan";
        } else { $judul = "masuk ke rek";
            $judul2 = "uang yg diterima";
        }

        $this->fields = [
            $this->fieldTanggal(),
            (new text)->make('ket'),
            (new number)->make('jumlah')->uang()->judul($judul2)->validate('required|lte:' . abs($keuangan->kekurangan))->default($keuangan->kekurangan),
            (new select)->make('akun_detail_id')->indexField('akunDetail->nama')->options($this->akunDetail)->validate('required')->judul($judul),
            (new hidden)->make('jenis')->default($keuangan->jenis),
            (new noForm)->make('user')->judul('user'),
        ];
    }
}
