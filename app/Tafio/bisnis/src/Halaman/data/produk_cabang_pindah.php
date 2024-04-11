<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use App\Tafio\bisnis\src\Models\produkStok;
use Session;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class produk_cabang_pindah extends Resource
{
    public function config()
    {
        $this->halaman = (new crud)->make()->route('create')->popup()
            ->redirect('bisnis/data/produk/' . ambil('produk') . '/cabang/' . ambil('cabang') . '/produkStok');

        $cabang = session('totalCabang');
        unset($cabang[ambil('cabang')]);

        $this->fields = [
            (new number)->make('jumlah')->validate('required'),
            (new select)->make('cabang_id')->judul('toko')->options($cabang)->validate('required'),
        ];
    }

    public function store_proses()
    {

        $cabang = session('totalCabang');

        ProdukStok::create([
            'produk_id' => ambil('produk'),
            'kurang' => request()->jumlah,
            'keterangan' => 'dipindah ke gudang ' . $cabang[request()->cabang_id],
            'kode' => 'pindah',
            'cabang_id' => ambil('cabang'),
        ]);

        ProdukStok::create([
            'produk_id' => ambil('produk'),
            'tambah' => request()->jumlah,
            'keterangan' => 'pindahan dari gudang ' . $cabang[ambil('cabang')],
            'kode' => 'pindah',
            'cabang_id' => request()->cabang_id,
        ]);
    }
}
