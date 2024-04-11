<?php

namespace app\Tafio\bisnis\src\Library;

use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\autocomplete;

trait templateFields
{
    public function fieldCabang()
    {
        if (count(session('totalCabang')) > 1) {
            return (new select)->make('cabang_id')->options(session('totalCabang'))
                ->validate('required')->default(session('cabang') != 0 ? session('cabang') : '');
        } else {
            return (new hidden)->make('cabang_id')->default(array_key_first(session('totalCabang')));
        }
    }

    public function fieldTanggal()
    {
        return (new noForm)->make('created_at')->judul('tanggal')->tanggal('d-m-Y');
    }

    public function fieldTanggal2()
    {
        return (new date)->make('created_at')->judul('tanggal')->tanggal('d-m-Y');
    }

    public function fieldSupplier()
    {
        return (new autocomplete)->make('kontak->namaLengkap')->judul('supplier')->model('bisnis.kontak')->namaField('kontak_id')->scope('supplier');
    }

    public function fieldProduk()
    {
        return (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk');        
    }

    public function fieldKonsumen()
    {
        return (new autocomplete)->make('kontak->namaLengkap')->judul('konsumen')->model('bisnis.kontak')->namaField('kontak_id')->scope('konsumen');
    }
}
