<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\produk;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\produkStok;
use App\Tafio\bisnis\src\Library\templateFields;

class produk_cabang_produkStok extends Resource
{
    use templateFields;
    public function config()
    {
        $menu=[];
        if(count(session('totalCabang'))>1)
        $menu['pindah gudang']='bisnis/data/produk/' . ambil('produk') . '/cabang/' . ambil('cabang') . '/pindah/create';

        $cabang = cabang::find(ambil('cabang'));
        $produk = produk::find(ambil('produk'));

        $this->halaman = (new crud)->make()
        ->judulLink([('produk stok > '.$produk->namaLengkap. ' > '.$cabang->nama) => ''])
        ->scope(percabang:[ambil('cabang')], perproduk:[ambil('produk')])
        ->popup()
        ->route('index','create')
        ->renameButtonTambah('stok opname')
        ->buttonIndex(...$menu);

        $this->fields = [
            $this->fieldTanggal(),
            (new hidden)->make('produk_id')->default(ambil('produk')),
            (new hidden)->make('cabang_id')->default(ambil('cabang')),
            (new text)->make('keterangan')->validate('required'),
            (new text)->make('kode')->disabled()->default('opname'),
            (new noForm)->make('hpp'),
            (new number)->make('tambah')->judul('penambahan'),
            (new number)->make('kurang')->judul('pengurangan'),
            (new noForm)->make('saldo')->judul('saldo akhir'),
            (new noForm)->make('user')->judul('user'),
        ];
    }
}
