<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\project;
use Tafio\core\src\Library\Field\email;
use Tafio\core\src\Library\Field\manySelect;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\vue;

class belumlunas extends Resource
{

    use tabs;
    public function config()
    {   


        $jenis=request()->jenis??'order';
        $pilihanTahun=null;


        if($jenis=='order')
        {
        $awal = project::orderBy('created_at','asc')->first()->created_at->year ?? 0;

        $skr = date('Y');
        $tahun = [];
        for ($i = $skr; $i >= $awal; $i--) {
            $tahun[$i] = $i;
        }
        $pilihanTahun=request()->tahun??date('Y');
        }
        
        
        $this->halaman = (new crud)->make('kontak')
        ->judul('transaksi blm lunas: '.$jenis)
            ->scope(jenis:[$jenis,$pilihanTahun])
        ->linkTabs(index:$this->tab_piutang())
        ->adaNomor()
        ->noPaginate()
            ->route('index');



        $this->fields = [
            (new noForm)->make('namaLengkap')->judul('nama')->sortable()->linkPopup('bisnis/data/kontak/{id}'),
            (new noForm)->make('CountBelumLunas')->judul('jumlah transaksi yg blm lunas'),
            (new noForm)->make('lastOrder')->judul('transaksi terakhir'),
            (new noForm)->make('saldo')->uang()->judul('total piutang')->linkPopUp('bisnis/data/kontak/{id}/keuangan'),
        ];
 
        if($jenis=='order'){

        $this->fields[]=
                (new select)->make('tahun')->search('noField', 'noQuery')->options($tahun)->default($skr);
        $this->fields[]=
                (new hidden)->make('jenis')->default($jenis)->search('noQuery');
        }
    }  

}
