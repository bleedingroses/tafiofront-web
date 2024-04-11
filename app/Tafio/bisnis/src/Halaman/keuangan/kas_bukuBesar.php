<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Library\templateFields;

class kas_bukuBesar extends Resource
{
    use templateFields;
    public function config()
    {
        $kas = akunDetail::where('id', ambil("kas"))->first()->saldo;
        $saldo = number_format($kas, 0, ",", ".");
        
        $this->halaman = (new crud)->make('akunDetail_bukuBesar')
        ->route('index','create')
        ->judul('kas','detail')
        ->infoIndex(saldo:['icon' => 'cash', 'isi' => $saldo])
        ->renameButtonTambah('pemasukan lain2')
        ->buttonIndex(...['transfer'=>'bisnis/keuangan/kas/' . ambil('kas') . '/transfer/create']);

        if($this->method=='index')   {      
            $this->fields = [
                $this->fieldTanggal2()->display('index')->search(),
                (new noForm)->make('kode'),
                (new noForm)->make('ketLink')->judul('keterangan'),
                (new noForm)->make('debet')->uang(),
                (new noForm)->make('kredit')->uang(),
                (new noForm)->make('saldo')->uang(),
                (new noForm)->make('user')->judul('user'),
            ];
        } else if($this->method=='create')   {      
           $this->fields = [
                // (new hidden)->make('akunDetail')->default($idKas),
                $this->fieldTanggal2()->default(date('Y-m-d')),
                (new number)->make('debet')->judul('jumlah')->validate('required'),
                (new text)->make('ket')->judul('keterangan'),
            ];
        }
    }

}
