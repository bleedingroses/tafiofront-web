<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use App\Tafio\bisnis\src\Models\poDetail;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;
class po_detail extends Resource
{
    use templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make('po_poDetail')
            ->route('edit', 'create', 'destroy')
            ->popup()
            ->redirect('bisnis/stok/po/' . ambil("po"));

        $poDetail = poDetail::find(ambil("detail"));

        $nilai = $poDetail ? ($poDetail->jumlahKedatangan ?? 0) : 0;

        $this->fields = [
            (new autocomplete)->make('produk->namaLengkap')->judul('produk')->model('bisnis.produk')->scope('beli')->namaField('produk_id')->validate('required')->display('create'),
            (new number)->make('jumlah')->validate('gte:' . $nilai . '')->display('create', 'edit'),
            (new text)->make('jumlahKedatangan')->default($nilai)->disabled()->display('edit'),
        ];
    }
}
