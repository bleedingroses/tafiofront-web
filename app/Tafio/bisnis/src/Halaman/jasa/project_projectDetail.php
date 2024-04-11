<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\grup;
use App\Tafio\bisnis\src\Models\project;
use App\Tafio\bisnis\src\Models\projectDetail;
use App\Tafio\bisnis\src\Models\projectFlow;
use App\Tafio\bisnis\src\Models\spek;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Controllers\Traits\prosesGambar;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\gambar;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;
class project_projectDetail extends Resource
{
    use prosesGambar,templateFields;
    public function config()
    {
        $this->project = ambil("project");

        $this->halaman = (new crud)->make()
            ->route('create', 'edit')
            ->judul('arsip produk')
            ->popUp()
            ->redirect('bisnis/jasa/project/' . $this->project);

        $this->spek = spek::get();

        if ($this->method == 'create') {
            $this->fields = [
                (new autocomplete)->make('produk->namaLengkap')->model('bisnis.produk')->namaField('produk_id')->scope('jual')->validate('required'),
                (new noForm)->make('project->kontak->namaLengkap')->judul('konsumen'),
                (new text)->make('tema'),
                (new number)->make('jumlah')->validate('required'),
                (new number)->make('harga')->validate('required')->uang(),
                (new textarea)->make('keterangan'),
                (new date)->make('deadline'),
                (new gambar)->make('picture')->validate('image|max:20000'),
            ];
            foreach ($this->spek as $value) {
                $this->fields[] = (new text)->make($value->nama);
            }
        }

        if ($this->method == 'edit') {
            $projectDetail = projectDetail::find(ambil("projectDetail"));

            if ($projectDetail->projectFlow->grup->nama == 'awal') {
                $this->fields = [
                    (new autocomplete)->make('produk->namaLengkap')->model('bisnis.produk')->namaField('produk_id')->scope('jual')->validate('required'),
                    (new text)->make('tema'),
                    (new number)->make('jumlah'),
                    (new number)->make('harga')->uang(),
                    (new textarea)->make('keterangan'),
                    (new date)->make('deadline'),
                    (new gambar)->make('picture')->validate('image|max:20000'),
                ];

                foreach ($this->spek as $value) {
                    $keterangan = null;
                    $xx = $projectDetail->spek->find($value->id);
                    if ($xx) {
                        $keterangan = $xx->pivot->keterangan;
                    }

                    $this->fields[] = (new text)->make($value->nama)->defaultEdit($keterangan);
                }
            } else {

                $this->fields = [
                    (new text)->make('tema'),
                    (new gambar)->make('picture')->validate('image|max:20000'),
                ];
            }
        }
    }

    public function store_proses()
    {
        request()->validate([
            'produk_id' => 'required',
            'jumlah' => 'required',
        ]);

        // ambil project flow setiap perusahaan
        $awal = grup::ambilFlow('awal');

        $idProject = $this->project;

        $gambar = null;
        if (request()->picture) {
            $gambar = $this->uploadGambar("projectDetail", request()->picture);
        }

        DB::transaction(function () use ($awal, $idProject, $gambar) {

            //insert project detail
            $dataDetail['project_id'] = $idProject;
            $dataDetail['produk_id'] = request()->input('produk_id');
            $dataDetail['tema'] = request()->input('tema');
            $dataDetail['jumlah'] = request()->input('jumlah');
            $dataDetail['harga'] = request()->input('harga');
            $dataDetail['keterangan'] = request()->input('keterangan');
            $dataDetail['project_flow_id'] = $awal;
            $dataDetail['deadline'] = request()->input('deadline');
            $dataDetail['picture'] = $gambar;
            $projectDetail = projectDetail::create($dataDetail);

            $this->insert_spek($projectDetail);

        });

    }

    public function update_proses($test)
    {
        DB::transaction(function () {

            $gambar = null;
            if (request()->picture) {
                $gambar = $this->uploadGambar("projectDetail", request()->picture);
            }

            //get projectDetail
            $projectDetail = projectDetail::find(ambil("projectDetail"));

            //update projectDetail

            if ($projectDetail->projectFlow->grup->nama == 'awal') {
                $projectDetail->update([
                    'produk_id' => request()->produk_id,
                    'tema' => request()->tema,
                    'jumlah' => request()->jumlah,
                    'harga' => request()->harga,
                    'keterangan' => request()->keterangan,
                    'deadline' => request()->deadline,
                    'picture' => $gambar,
                ]);
                $this->insert_spek($projectDetail);
            } else {
                $projectDetail->update([
                    'tema' => request()->tema,
                    'picture' => $gambar,
                ]);
            }

        });

    }

    public function insert_spek($projectDetail)
    {
        $sync = [];
        foreach ($this->spek as $spek) {
            if (request()->{$spek->nama}) {
                $sync[$spek->id] = ['keterangan' => request()->{$spek->nama}];
            }

        }
        $projectDetail->spek()->sync($sync);
    }
}
