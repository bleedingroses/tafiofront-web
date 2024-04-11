<?php

namespace App\Observers;

use App\Tafio\bisnis\src\Models\akunDetail;

class AkunDetailObserver
{
    public function creating(akunDetail $akunDetail)
    {
        $lama = akunDetail::where('akun_kategori_id', request()->akun_kategori_id)->orderBy('id', "DESC")->first();
        if ($lama) {
            $urutan = substr($lama->no_akun, -2);
            $urutan++;
            $noAkun = $lama->akun_kategori_id . "0" . $urutan;
            $akunDetail->no_akun = $noAkun;
        } else {
            $urutan = 1;
            $akunDetail->no_akun = request()->akun_kategori_id. "0" . $urutan;
        }

    }
}
