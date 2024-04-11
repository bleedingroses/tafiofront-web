<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\bukuBesar;
use Illuminate\Support\Facades\DB;
use Session;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class kas_transfer extends Resource
{
    public function config()
    {
        $idKas = ambil("ka");
        $this->akun = akunDetail::kas()->where('id', '!=', $idKas)->get()->pluck('nama', 'id');

        $this->halaman = (new crud)->make('akunDetail_transfer')
            ->route('create')
            ->scope('kas')
            ->redirect('bisnis/keuangan/kas/' . ambil("ka") . '/bukuBesar');

        $kas = akunDetail::kas()->where('id', $idKas)->first();

        $this->fields = [
            (new hidden)->make('akun_detail_dari')->default($idKas),
            (new text)->make('nama')->default($kas->nama)->disabled(),
            (new text)->make('saldo')->default($kas->saldo)->disabled(),
            (new date)->make('tgl')->default(date('Y-m-d'))->judul('tanggal'),
            (new select)->make('akun_detail_tujuan')->options($this->akun)->validate('required')->judul('masuk ke rek'),
            (new number)->make('jumlah')->validate('required'),
            (new text)->make('keterangan'),
        ];
    }

    public function store_proses()
    {
        DB::transaction(function () {

            $akunDetailKe = akunDetail::find(request()->akun_detail_tujuan);
            $akunDetailDari = akunDetail::find(request()->akun_detail_dari);

            bukuBesar::create([
                'akun_detail_id' => request()->akun_detail_dari,
                'kode' => 'trf',
                'ket' => 'transfer ke ' . $akunDetailKe->nama,
                'kredit' => request()->jumlah,
                'debet' => 0,
            ]);

            //insert into buku besar table tujuan
            bukuBesar::create([
                'akun_detail_id' => request()->akun_detail_tujuan,
                'kode' => 'trf',
                'ket' => 'transfer dari ' . $akunDetailDari->nama,
                'kredit' => 0,
                'debet' => request()->jumlah,
            ]);
        });

    }
}
