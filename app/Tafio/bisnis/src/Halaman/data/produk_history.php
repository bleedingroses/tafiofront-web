<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Models\produk;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;

class produk_history extends Resource
{
    public function config()
    {
        $produk = produk::find(ambil("produk"));
        $data = $produk->nama ? '('.$produk->nama.')': '';

        $this->halaman=(new crud)->make()
        ->route('index')
        ->infoIndex(...[
            'nama produk' => ['icon' => 'user', 'isi' => $produk->produkModel->nama.$data],
        ])->popup();

        $this->fields = [
            (new noForm)->make('keterangan'),
            (new noForm)->make('produk->produkModel->satuan')->judul('satuan'),
            (new noForm)->make('jumlah'),
            (new noForm)->make('harga')->uang(),
            (new noForm)->make('total')->uang(),
            (new noForm)->make('belanja->tanggal_beli')->judul('tanggal beli'),
            (new noForm)->make('belanja->kontak->namaLengkap')->judul('supplier'),
        ];
    }
}
