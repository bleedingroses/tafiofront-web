<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class pakaiStok extends Resource
{
    use templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make('produkStok')->scope('pakai')->route('index', 'create')->judul('pakai stok');

        $this->fields = [
            $this->fieldTanggal(),
            (new autocomplete)->make('namaLengkap')->display('create')->judul('produk')->model('bisnis.produk')->namaField('produk_id')->scope('stok')->validate('required'),
            (new noForm)->make('produk->produkModel->nama'),
            (new number)->make('kurang')->judul('jumlah'),
            (new textarea)->make('keterangan'),
            (new text)->make('kode')->disabled()->default('pakai')->display('create'),
            $this->fieldCabang(),
            (new noForm)->make('user')->judul('user'),
        ];

    }
}
