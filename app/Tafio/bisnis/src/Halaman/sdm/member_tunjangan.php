<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\bukuBesar;
use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Models\tunjangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;

class member_tunjangan extends Resource
{
        use templateFields;
    public function config()
    {
        $this->member = ambil("member");

        $this->halaman = (new crud)->make('member_tunjangan')
            ->judul(...['pegawai aktif', 'tunjangan'])
            ->route('index', 'create')
            ->popup();

        $this->fields = [
            $this->fieldTanggal()->displayFront(),
            (new text)->make('ket')->displayFront(),
            (new number)->make('jumlah')->validate('required')->uang()->displayFront(),
            (new noForm)->make('saldo')->uang()->displayFront(),
            (new select)->make('akun_detail_id')->judul('kas')->options(akunDetail::kas()->pluck('nama', 'id'))->validate('required')->displayFront(),
        ];
    }

    public function store_proses()
    {
        DB::transaction(function () {
            //get tunjangan sebelumnya
            $tunjangan = tunjangan::where('member_id', $this->member)->whereYear('created_at', '=', Carbon::now()->year)
                ->orderBy('id', 'DESC')->first();
            isset($tunjangan->saldo) ? $saldo = $tunjangan->saldo : $saldo = 0;
            $total = $saldo + request()->jumlah;

            //insert data
            $data = request()->except('_token');
            $data['member_id'] = $this->member;
            $data['saldo'] = $total;
            tunjangan::create($data);

            //get nama member untuk ket gaji
            $member = member::find($this->member);

            //insert into buku besar table
            bukuBesar::create([
                'akun_detail_id' => request()->akun_detail_id,
                'ket' => 'tunjangan ke ' . $member->kontak->namaLengkap,
                'kredit' => request()->jumlah,
            ]);
        });

    }

}
