<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Models\member;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\custom;
use App\Tafio\bisnis\src\Models\absensi as modelAbsensi;
use Session;

class absensi extends Resource
{
    public function config()
    {
        $this->halaman = (new custom)->make()->route('index', 'create')->customView("custom.sdm.absensi");
        $this->absensi = modelAbsensi::where('in', '>=', date("Y-m-d"))->get();
        $this->fields = [
            (new noForm)->make('member->nama'),
            (new noForm)->make('rfid'),
            (new noForm)->make('in'),
            (new noForm)->make('out'),
        ];
    }

    public function store_proses()
    {
        $userIp = request()->ip();
        $client = new Client();
        $response = $client->get("https://ipinfo.io/{$userIp}?token=5c7d2c0413f566");
        $data = json_decode($response->getBody());

        request()->validate([
            'rfid' => 'required',
        ]);

        $absensi = modelAbsensi::where('in', '>=', date("Y-m-d"))->where('rfid', request()->rfid)->first();
        if ($absensi) {
            $absensi->update([
                'out' => Carbon::now(),
            ]);
            return $absensi;
        } else {
            $member = member::where('rfid',request()->rfid)->first();
           
            if ($member) {
                $absen['in'] = Carbon::now();
                $member = DB::table('hrd_members')->where('rfid', request()->rfid)->first();
                $absen['member_id'] = $member ? $member->id : null;
                $absen['company_id'] = $member ? $member->company_id : null;
                $absen['rfid'] = request()->rfid;
                $absen['kota'] = $data->city ?? null;
                $absen['lokasi'] = $data->loc ?? null;
                $id = modelAbsensi::create($absen);
                return $id;
            } else {
                Session::flash('flash_error', 'rfid tidak ditemukan');
                return redirect(url('bisnis/data/absensi'));
            }
        }
    }
}
