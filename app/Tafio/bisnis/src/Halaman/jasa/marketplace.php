<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\select;
use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Library\templateFields;

class marketplace extends Resource
{
    use templateFields;
    public function config()
    {

        $this->halaman = (new crud)->make('marketplaceConfig')->judul('marketplace upload');
 


        $this->fields = [

            (new text)->make('nama')->validate('required')->link('bisnis/jasa/marketplace/{id}/upload/create'),
            (new select)->make('marketplace')->options(['shopee' => 'shopee', 'tokopedia' => 'tokopedia', 'lazada' => 'lazada']),
            (new number)->make('harga')->judul('harga<br>dinaikin(%)')->default(10),
            (new toggle)->make('baruOrder')->default(1)->judul('order <br>baru?'),
            (new toggle)->make('baruKeuangan')->default(1)->judul('keuangan <br>baru?'),
            (new autocomplete)->make('kontak->namaLengkap')->judul('konsumen')->model('bisnis.kontak')->namaField('kontak_id')->scope('marketplace')->validate('required'),
            (new select)->make('kas_id')->judul('kas<br>marketplace')->options(akunDetail::kasMarketplace()->get()->pluck('nama','id'))->validate('required'),
            (new select)->make('penarikan_id')->judul('kas<br>penarikan')->options(akunDetail::kas()->get()->pluck('nama','id'))->validate('required'),
            (new noForm)->make('sinkron'),
            $this->fieldCabang()
    ];
          
          
          
    
    }
       
    
}
