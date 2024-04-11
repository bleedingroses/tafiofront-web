<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Models\authlevel;
use App\Tafio\bisnis\src\Models\gaji;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\level;
use App\Tafio\bisnis\src\Models\bagian;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Library\templateFields;

class member_gaji extends Resource
{
    use templateFields;
    public function config()
    {
        $this->member = ambil("member");
        $memberx=member::find($this->member);
        $this->gaji = $memberx->gaji->last();
        
        if (!empty($this->gaji)) {
            $this->level = $this->gaji->level_id; 
            $this->bagian = $this->gaji->bagian_id; 
            $this->performance = $this->gaji->performance; 
            $this->transportasi = $this->gaji->transportasi; 
            $this->lain2 = $this->gaji->lain2; 
            $this->jumlah_lain = $this->gaji->jumlah_lain; 
        }else{
            $this->level = ""; 
            $this->bagian = ""; 
            $this->performance = ""; 
            $this->transportasi = ""; 
            $this->lain2 = 0; 
            $this->jumlah_lain = 0;
        }

        $this->halaman=(new crud)->make('member_gaji')      
        ->judul(...['pegawai aktif', 'gaji'])
        ->route('index', 'create')
        ->popup();

        $this->fields = [
            (new hidden)->make('member_id')->default($this->member),
           $this->fieldTanggal(),
            (new select)->make("bagian_id")->options(bagian::get()->pluck('nama', 'id'))->default($this->bagian)->validate('required'),
            (new select)->make('level_id')->options(level::get()->pluck('nama', 'id'))->default($this->level)->validate('required'),
            (new select)->make("performance")->options(['0','1','2','3','4','5'])->default($this->performance)->validate('required'),
            (new toggle)->make("transportasi")->default($this->transportasi)->validate('required'),
            (new text)->make("lain2")->judul('tunjangan lain'),
            (new number)->make("jumlah_lain")->default($this->jumlah_lain)->judul('	nilai tunjangan lain2')->uang(),
        ];
    }

}
