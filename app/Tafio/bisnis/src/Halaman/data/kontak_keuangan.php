<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Models\kontak;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class kontak_keuangan extends resource
{
    use templateFields;

    public function config()
    {
        $this->kontak = kontak::find(ambil('kontak'));
        $this->akunDetail = akunDetail::kas()->pluck('nama', 'id');

        $total = 0;
        $this->halaman = (new crud)->make()
            ->judulLink([('keuangan: ' . $this->kontak->nama) => ''])
            ->route('index', 'create')
        // ->scope('belumLunas')
            ->renameButtonTambah('ambil hutang')
            ->popup()
            ->buttonIndex(...['beri piutang' => 'bisnis/data/kontak/' . ambil('kontak') . '/keuangan/create?hutang=1'])
            ->infoIndex(...[
                'total piutang' => ['icon' => 'user', 'isi' => $this->kontak->saldo]]);

        $pemasukan = "kasbon";
        $pengeluaran = "pembayaran";
        $kas = 'kas';
        $jenis = 'piutang';
        $judul = "total";
        if ($this->method == 'create') {
            $pengeluaran = "bayar hutang sebesar";
            $pemasukan = "hutang baru sebesar";

            if (request()->hutang == 1) {$kas = 'dari kas';
                $judul = "jumlah piutang yg diberikan";
            } else {

                $kas = 'masuk ke kas';
                $jenis = 'hutang';
                $judul = "jumlah hutang yg diambil";
            }
        }

////jenis ada 4: hutang, piutang, order, belanja
        $this->fields = [
            $this->fieldTanggal(),
            (new text)->make('jenis')->default($jenis)->disabled(),
            (new number)->make('total')->judul($judul)->linkPopup('bisnis/data/keuangan/{id}/keuanganDetail')->validate('required'),
            (new text)->make('ket'),
            (new noForm)->make('kekurangan')->uang(),
            (new select)->make('akun_detail_id')->indexField('akunDetail->nama')->options($this->akunDetail)->validate('required')->judul($kas),
            (new noForm)->make('user')->judul('user'),
        ];

    }
    public function after_store($model)
    {
        if (request()->jenis == 'hutang') {
            $ket = "hutang ke " . $this->kontak->namaLengkap;
            $debet = request()->total;
            $kredit = 0;
            $kode = 'htg';
        } else {
            $debet = 0;
            $kredit = request()->total;
            $ket = "beri piutang ke " . $this->kontak->namaLengkap;
            $kode = 'ptg';

        }

        $model->akunDetail->bukuBesar()->create([
            'ket' => $ket,
            'kredit' => $kredit,
            'debet' => $debet,
            'detail_id' => $model->id,
            'kode' => $kode
        ]);
    }

}
