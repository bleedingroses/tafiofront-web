<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Models\belanja;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class belanja_belanjaDetail extends Resource
{
    public function config()
    {
        $belanja = belanja::find(ambil("belanja"));
        if ($belanja->keuangan) {
            $keuangan = ['icon' => 'cash', 'isi' => "<a class=' popup-tafio' href=" . url('bisnis/data/keuangan/' . $belanja->keuangan->id . '/keuanganDetail') . ">" . number_format($belanja->keuangan->kekurangan, 0, ",", ".") . "</a>"];
        } else {
            $keuangan = ['icon' => 'cash', 'isi' => 0];
        }

        $this->halaman = (new crud)->make('belanja_belanjaDetail')
            ->route('index')
            ->popup()
            ->infoIndex(...[
                'nota' => ['icon' => 'cash', 'isi' => $belanja->nota],
                'supplier' => ['icon' => 'cash', 'isi' => $belanja->kontak->namaLengkap],
                'diskon' => ['icon' => 'cash', 'isi' => $belanja->diskon],
                'total' => ['icon' => 'cash', 'isi' => number_format($belanja->total, 0, ",", ".")],
                'kekurangan' => $keuangan,
            ]);

        $this->fields = [
            (new noForm)->make('produk->namaLengkap'),
            (new noForm)->make('keterangan'),
            (new noForm)->make('produk->produkModel->satuan')->judul('satuan'),
            (new noForm)->make('jumlah'),
            (new noForm)->make('harga')->uang(),
            (new noForm)->make('total')->uang(),
        ];
    }
}
