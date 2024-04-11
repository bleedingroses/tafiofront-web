<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Models\absensi;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;

class member_absen extends Resource
{
    public function config()
    {
        $this->member = ambil("member");

        $member = member::find(ambil("member"));
        $awal = absensi::orderBy('created_at','asc')->first()->created_at->year ?? 0;

        $skr = date('Y');
        $tahun = [];
        for ($i = $skr; $i >= $awal; $i--) {
            $tahun[$i] = $i;
        }
        $pilihanTahun=request()->tahun??date('Y');

        $bulan = [];
        for ($m=1; $m<=12; $m++) {
            $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
            $bulan[$m] = $month;
        }
        $pilihBulan=request()->bulan??date('m');

        $this->halaman = (new crud)->make()
            ->scope(jenis:[$pilihanTahun,$pilihBulan])
            ->route('create','index')
            ->adanomor()
            ->redirect('bisnis/sdm/member')
            ->popup();

        $this->fields = [
            (new text)->make('rfid')->display('create'),
            (new text)->make('in')->display('index'),
            (new text)->make('out')->display('index'),
            (new select)->make('bulan')->search('noField', 'noQuery')->options($bulan)->default(date('m')),
            (new select)->make('tahun')->search('noField', 'noQuery')->options($tahun)->default($skr),
        ];
    }

    public function store_proses()
    {
        $member = member::find(ambil("member"));
        $member->update([
            "rfid" => request()->rfid,
        ]);
        return $member;
    }
}
