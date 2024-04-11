<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use Tafio\core\src\Library\vue;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\kontak;
use App\Tafio\bisnis\src\Models\member as modelMember;
use Tafio\core\src\Library\Field\radio;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\toggle;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\textarea;

class member extends Resource
{
    use tabs;

    public function config()
    {
        $this->halaman=(new crud)->make()      
        ->judul('pegawai aktif')
        ->scope('aktif')
        ->route('index', 'show', 'edit', 'create')
        ->linkTabs(index:$this->tab_aktif())
        ->orderBy('lamaKerja')
        ->noPaginate();

        if (session('cabang') != 0) {
            $this->halaman->scope('aktif',percabang:[session('cabang')]);
        }


        $this->fields = [
            (new noForm)->make('kontak->namaLengkap')->displayFront()->linkShow()->sortable(),
            (new text)->make('nama')->display('create','edit')->validate('required'),
            (new noForm)->make('user->email')->displayFront()->ifEmpty('blm dibuat')->linkPopUp('bisnis/sdm/member/{id}/user'),
            (new text)->make('namaPanggilan'),
            (new radio)->make('jenisKelamin')->options(['laki-laki' => 'laki-laki', 'perempuan' => 'perempuan']),
            (new text)->make('nik'),
            (new date)->make('tglMasuk')->default(date('Y-m-d')),
            (new toggle)->make('aktif')->default('ya'),
            (new date)->make('tglKeluar')->vue((new vue)->type('showInverse')->dependFields('aktif')),
            (new text)->make('tempatLahir'),
            (new date)->make('tglLahir'),
            (new noForm)->make('kontak->alamat')->judul("alamat"),
            (new textarea)->make('alamat')->display('create'),
            (new noForm)->make('kontak->noTelp')->judul("hp"),
            (new text)->make('noTelp')->display('create')->validate('required'),
            (new select)->make('statusPernikahan')->options(['Belum Menikah' => 'Belum Menikah', 'Menikah' => 'Menikah', 'Pernah Menikah' => 'Pernah Menikah']),
            (new number)->make('jumlahAnak')->vue((new vue)->type('show')->dependFields('statusPernikahan')),
            (new select)->make('golonganDarah')->options([1 => 'A', 'B', 'AB', 'O', '-']),
            (new text)->make('noRekening'),
            (new select)->make('cabang_id')->options(session('totalCabang')),
            (new gambar)->make('ttd'),
            (new noForm)->make('countCuti')->displayFront()->judul('Cuti')->linkPopUp('bisnis/sdm/member/{id}/cuti'),
            (new noForm)->make('countIjin')->displayFront()->judul('Ijin')->linkPopUp('bisnis/sdm/member/{id}/cuti'),
            (new noForm)->make('kontak->saldo')->displayFront()->judul('kasbon')->uang()->linkPopUp('bisnis/data/kontak/{kontak->id}/keuangan'),
            (new noForm)->make('countLembur')->displayFront()->judul('Lembur')->linkPopUp('bisnis/sdm/member/{id}/lembur'),
            (new noForm)->make('countTunjangan')->displayFront()->judul('tunjangan')->uang()->linkPopUp('bisnis/sdm/member/{id}/tunjangan'),
            (new noForm)->make('Umur')->displayFront(),
            (new noForm)->make('lamaKerja')->displayFront(),
            (new number)->make('tglGajian')->displayFront()->linkPopUp('bisnis/sdm/member/{id}/penggajian'),
            (new noForm)->make('level')->displayFront()->linkPopUp('bisnis/sdm/member/{id}/gaji'),
            (new noForm)->make('rfid')->displayFront(),
        ];
    }

    public function store_proses()
    {
        $kontak = kontak::create([
            'nama' => request()->nama,
            'alamat' => request()->alamat,
            'noTelp' => request()->noTelp,
            'lainnya' => 1,
        ]);
        $data = request()->except(['nama', 'alamat', 'noTelp', '_token']);
        $data['kontak_id'] = $kontak->id;
        $member = modelMember::create([
            "namaPanggilan" => request()->namaPanggilan,
            "jenisKelamin" => request()->jenisKelamin,
            "nik" => request()->nik,
            "aktif" => request()->aktif,
            "tglMasuk" => request()->tglMasuk,
            "tglKeluar" => request()->tglKeluar,
            "tempatLahir" => request()->tempatLahir,
            "tglLahir" => request()->tglLahir,
            "statusPernikahan" => request()->statusPernikahan,
            "jumlahAnak" => request()->jumlahAnak,
            "golonganDarah" => request()->golonganDarah,
            "noRekening" => request()->noRekening,
            "cabang_id" => request()->cabang_id,
            "tglGajian" => request()->tglGajian,
            "kontak_id" => $kontak->id,
        ]);

        return $member;
    }

}
