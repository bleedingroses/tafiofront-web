<?php

namespace App\Tafio\bisnis\src\Halaman\marketing;

use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\kontak;
use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Models\projectMarketing;
use Illuminate\Support\Carbon;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\custom;
use App\Tafio\bisnis\src\Library\templateFields;
class dashboard extends Resource
{
    use templateFields;
    public function config()
    {
        $this->halaman=(new custom)->make('projectMarketing')->customView("custom.marketing.dashboard")->route('index');
        $this->ar = ar::pluck('kode', 'kode');
        $member = member::where('user_id', auth()->user()->id)->first();
        
        if ($member) {
            $this->arUser = ar::where('member_id', $member->id)->first();
        }
        $this->blmTerdaftar = projectMarketing::blmTerdaftar();
        $this->terdaftar = projectMarketing::terdaftar();

        $this->fields = [
            $this->fieldKonsumen()->validate('required'),
            (new text)->make('via'),
            (new text)->make('pertanyaan')->judul('rencana order'),
            (new date)->make('followup_next')->judul('follow up lagi'),
        ];
    }

    public function store_proses()
    {
        //get user id
        $idUser = auth()->user()->id;

        //get member id
        $members = member::where('user_id', $idUser)->first();
        $ar = ar::where('member_id', $members->id)->first();

        $data = request()->except('_token', 'nama');
        $data['status'] = 'proses';
        $data['kontak_id'] = request()->nama;
        $data['ar_id'] = $ar->id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        projectMarketing::insert($data);
    }

}
