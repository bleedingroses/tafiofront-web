<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\bagian;
use App\Tafio\bisnis\src\Models\bukuBesar;
use App\Tafio\bisnis\src\Models\gaji;
use App\Tafio\bisnis\src\Models\kasbon;
use App\Tafio\bisnis\src\Models\lembur;
use App\Tafio\bisnis\src\Models\level;
use App\Tafio\bisnis\src\Models\member;
use App\Tafio\bisnis\src\Models\penggajian;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;

class member_penggajian extends Resource
{

        use templateFields;
    public function config()
    {

        $this->member = ambil("member");
        $this->pegawai = member::find(ambil("member"));
        $hijriyah = tgl_hijriyah();

        if ($this->method == 'create') {

            //get data gaji
            $this->gaji = $this->pegawai->gaji->last();
            $this->level = $this->gaji->level;
            $this->bagian = $this->gaji->bagian;

            //menghitung tahun kerja
            $tahun_kerja = hitungTahun($this->pegawai->tglMasuk)['tahun'];

            //menghitung tunjangan bagian, performance & lama kerja
            $grade = $this->bagian->grade;
            $this->gapok = $this->level->gaji_pokok;
            $this->transportasi = $this->gaji->transportasi;

            if ($this->transportasi == 1) {
                $this->transportasi = $this->level->transportasi;
            } else {
                $this->transportasi = 0;
            }

            $this->tBagian = 0.1 * $grade * $this->gapok;
            $this->performance = $this->gaji->performance * 0.1 * $this->gapok;
            $this->lamaKerja = ($tahun_kerja * $this->level->lama_kerja * $this->gapok) / 100;

            $this->jmlLembur = $this->pegawai->lembur()->where('dibayar', 'belum')->sum('jam');

            $this->totalKasbon = $this->pegawai->kontak->saldo ?? 0;

            $maks_kasbon = floor($this->gapok / 3 / 100000) * 100000;
            if ($this->totalKasbon > $maks_kasbon) {
                $this->totalKasbon = $maks_kasbon;
            }

            $this->totalLembur = ($this->gapok / 25 / 8) * 1.5 * $this->jmlLembur;
        }

        // setting halaman
        $this->halaman = (new crud)->make('member_penggajian')
            ->judul(...['pegawai aktif', 'penggajian'])
            ->route('index', 'create')
            ->popup()
            ->renameButtonTambah('bayar gaji')
            ->customForm('custom.sdm.formGajian');

        $this->kas = akunDetail::kas()->get();

        if ($this->method == 'index') {
            $penggajian = $this->pegawai->penggajian->last();
            if ($penggajian) {
                $bulanHijriyah = array_search($penggajian->bulan, bln_hijriyah());
                if ($bulanHijriyah == $hijriyah['bulan'] && $penggajian->tahun == $hijriyah['tahun']) {
                    $this->halaman->noCreateButton();
                }
            }
        }

        $this->fields = [
            $this->fieldTanggal()->displayFront(),
            (new noForm)->make('member->kontak->namaLengkap')->judul('nama'),
            (new noForm)->make('tahun')->displayFront(),
            (new noForm)->make('bulan')->displayFront(),
            (new noForm)->make('pokok')->displayFront()->uang(),
            (new noForm)->make('lama_kerja')->judul('lama kerja')->displayFront()->uang(),
            (new noForm)->make('bagian')->displayFront()->uang(),
            (new noForm)->make('performance')->displayFront()->uang(),
            (new noForm)->make('transportasi')->displayFront()->uang(),
            (new noForm)->make('komunikasi')->displayFront()->uang(),
            (new noForm)->make('kehadiran')->displayFront()->uang(),
            (new noForm)->make('jumlah_lain')->displayFront()->judul('jumlah lain')->uang(),
            (new noForm)->make('lain2')->displayFront()->judul('ket lain'),
            (new noForm)->make('potongan'),
            (new noForm)->make('keluarga'),
            (new noForm)->make('jam_lembur')->displayFront()->judul('jam lembur'),
            (new noForm)->make('lembur')->displayFront()->uang(),
            (new noForm)->make('kasbon')->displayFront()->judul('potong kasbon')->uang(),
            (new noForm)->make('bonus')->displayFront()->uang(),
            (new noForm)->make('total')->displayFront()->uang(),
            (new noForm)->make('slip')->value('<button class="btn btn-rounded btn-info btn-sm">slip gaji</button>')->link('bisnis/sdm/slipGaji?idSLipGaji={id}')->displayFront(),
        ];
    }

    public function store_proses()
    {

        request()->validate(['akun_detail_id' => 'required']);

        DB::transaction(function () {
            $hijriyah = tgl_hijriyah();
            $bulan = $hijriyah['bulan'];
            $tahun = $hijriyah['tahun'];

            //insert into penggajian
            penggajian::create([
                'member_id' => request()->member_id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'akun_detail_id' => request()->akun_detail_id,
                'jam_lembur' => request()->jam_lembur,
                'pokok' => request()->pokok,
                'lembur' => request()->lembur,
                'bonus' => request()->bonus,
                'total' => request()->total,
                'lama_kerja' => request()->lama_kerja,
                'bagian' => request()->bagian,
                'performance' => request()->performance,
                'transportasi' => request()->transportasi,
                'komunikasi' => request()->komunikasi,
                'kehadiran' => request()->kehadiran,
                'jumlah_lain' => request()->jumlah_lain,
                'lain2' => request()->lain2,
                'kasbon' => request()->kasbon,
            ]);

            if (request()->kasbon) {
                $kasbon = request()->kasbon;

                $keuangan = $this->pegawai->kontak->keuangan()->where('kekurangan', '>', 0)->oldest()->get();

                foreach ($keuangan as $hasil) {
                    if ($kasbon > $hasil->kekurangan) {
                        $hasil->keuanganDetail()->create(['jumlah' => $hasil->kekurangan, 'ket' => "potong gaji"]);
                        $kasbon = $kasbon - $hasil->kekurangan;
                    } else {
                        $hasil->keuanganDetail()->create(['jumlah' => $kasbon, 'ket' => "potong gaji"]);
                        break;
                    }
                }

            }

            if (request()->jam_lembur) {
                $this->pegawai->lembur()->where('dibayar', 'belum')->update(['dibayar' => 'sudah']);
            }

            //insert into buku besar table
            bukuBesar::create([
                'akun_detail_id' => request()->akun_detail_id,
                'ket' => 'bayar gaji ke ' . $this->pegawai->nama,
                'kredit' => request()->total,
                'kode' => 'gji',
                'debet' => 0,
            ]);
        });
    }

}
