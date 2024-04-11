<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Models\authlevel;
use Tafio\core\src\Models\User;
use Tafio\core\src\Library\Field\email;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\password;
use Tafio\core\src\Library\Halaman\crud;

class member_user extends Resource
{
    public function config()
    {
        $this->member = ambil("member");

        $this->halaman=(new crud)->make('member_user')      
        ->judul(...['pegawai aktif', 'user'])->tampilanDetail()
        ->popup();

        $this->fields = [
            (new email)->make('email')->validate('email|unique:core_users'),
            (new password)->make('password'),
            (new select)->make('authlevel_id')->judul('level akses')->options(authlevel::get()->pluck('nama', 'id'))->disabled()->default(8),
        ];
    }
    
    public function store_proses()
    {        
        $input = request()->input();
        $input['company_id'] = session('company');
        $user = User::create($input);
        $member = member::find($this->member)->update(['user_id' => $user->id]);
    }

}
