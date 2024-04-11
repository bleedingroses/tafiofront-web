<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Models\project;
use Tafio\core\src\Library\Halaman\custom;
use Tafio\core\src\Library\Resource;

class project_invoice extends Resource
{
    public function config()
    {
        $this->halaman = (new custom)->make()->customView("custom.jasa.invoice")->route('index', 'show')->popUp()->judul('project', 'invoice');
        //data di halaman
        $this->project = project::find(ambil("project"));
        $this->member = member::where('user_id', auth()->user()->id)->first();
        $this->ar = false;
        if ($this->member) {
            $this->ar = $this->member->ar;
        }
        $this->logo = moduleConfig('core', 'logo');
        $this->nama = moduleConfig('core', 'nama');
        $this->stempel = moduleConfig('bisnis', 'stempel');

        if (session('cabang') == 0) {
            $cabang = cabang::first();
        } else {
            $cabang = cabang::find(session('cabang'));
        }

        $this->alamatKantor = $cabang->alamat;
        $this->rek = $cabang->rek;
    }

}
