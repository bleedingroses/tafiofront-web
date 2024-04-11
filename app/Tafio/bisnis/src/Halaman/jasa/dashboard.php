<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\grup;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Halaman\custom;
use Tafio\core\src\Library\Resource;

class dashboard extends Resource
{
    public function config()
    {
        $this->halaman = (new custom)->make()->customView("custom.jasa.dashboard");
        $this->grups = grup::where('nama', '!=', 'batal')->where('nama', '!=', 'finish')->get();
        $this->ar = ar::pluck('kode', 'kode');
        $member = member::where('user_id', auth()->user()->id)->first();
        if ($member) {
            $this->arUser = ar::where('member_id', $member->id)->first();
        }
    }
}
