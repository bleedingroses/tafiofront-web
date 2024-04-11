<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Session;
use App\Tafio\bisnis\src\Library\templateFields;
use Illuminate\Support\Carbon;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Models\grup;
use App\Tafio\bisnis\src\Models\spek;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\kontak;
use Tafio\core\src\Library\Field\radio;
use App\Tafio\bisnis\src\Models\process;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\statis;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\custom;
use App\Tafio\bisnis\src\Models\projectFlow;
use App\Tafio\bisnis\src\Models\projectDetail;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Models\project as modelProject;

class project extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->route('index', 'edit', 'create','show');

        if($this->method=='index'){        
            $this->halaman->judul('arsip order')
            ->scope('search')
            ->linkTabs(show:$this->tab_project())
            ->noEditButton()
            ->noCreateButton();

            if (session('cabang') != 0) {
                $this->halaman->scope(percabang:[session('cabang')]);
            }

            $this->fields = [
                $this->fieldTanggal2()->display('index')->search()->sortable(),
                (new noForm)->make('nota')->judul('nota'),
                $this->fieldKonsumen()->display('index')->search(),
                (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk')->search('noField','noQuery')->scope('jual')->validate('required'),
                (new noForm)->make('listproduk')->judul('Order')->linkShow(),
                (new noForm)->make('total')->uang()->judul("Total"),
                (new noForm)->make('keuangan->kekurangan')->uang()->judul('kekurangan')->linkPopup('bisnis/data/keuangan/{keuangan->id}/keuanganDetail'),
                (new noForm)->make('user')->judul('user'),
            ];
        }

        else if ($this->method == 'show') 
        {
            $this->projects = modelProject::find(ambil("project"));
            $this->halaman=(new custom)->make()->haveShow()
            ->customViewShow("custom.jasa.projectDetail")->
            judul('project detail')->
            linkTabs(show:$this->tab_project())->popUp();

            //semua data di halaman
            $this->proses = process::get();

            $produksi=grup::ambil('produksi');
            $this->projectFlowProduksi = projectFlow::orderBy('urutan')->get()->pluck('nama', 'id');        
            $this->jadwal = $produksi->projectFlow;
        }

        else if ($this->method == 'edit') {
            $this->halaman->popUp();
            $this->fields = [
                (new statis)->make('kontak->namaLengkap')->judul('konsumen'),
                (new text)->make('konsumen_detail')->judul('konsumen detail'),
                (new number)->make('diskon'),
                (new text)->make('ket_diskon')->judul('ket diskon'),
                (new radio)->make('pengiriman')->options(['diambil' => 'diambil', 'diantar' => 'diantar ke alamat', 'jasa' => 'pakai jasa pengiriman']),
                (new radio)->make('invoice')->options(['disertakan' => 'disertakan dengan barang', 'terpisah' => 'dikirim terpisah', 'email' => 'diemail', 'tidak' => 'tidak pakai']),
                (new radio)->make('jenis_pembayaran')->options(['cod' => 'cod', 'transfer' => 'transfer'])->judul('pembayaran'),
                (new text)->make('jasa')->judul('jasa pengiriman'),
                (new number)->make('ongkir'),
                (new textarea)->make('ket_kirim')->judul('keterangan'),
            ];
        }
        else if ($this->method == 'create') {
            $this->halaman->popUp();
            $this->fields = [
                $this->fieldKonsumen()->search()->validate('required'),
                (new text)->make('konsumen_detail')->judul('konsumen detail'),
                (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk')->search()->namaField('produk_id')->scope('jual')->validate('required'),
                (new text)->make('nota'),
                (new text)->make('konsumen_detail')->judul('konsumen detail'),
                (new text)->make('tema'),
                (new number)->make('jumlah')->validate('required'),
                (new number)->make('harga')->validate('required'),
            ];

            $spek = spek::get();

            foreach ($spek as $value) {
                $this->fields[] = (new text)->make($value->nama);
            }

            $this->fields[] = (new textarea)->make('keterangan');
            $this->fields[] = (new date)->make('deadline');
            $this->fields[] = (new radio)->make('pengiriman')->options(['diambil' => 'diambil', 'diantar' => 'diantar ke alamat', 'jasa' => 'pakai jasa pengiriman']);
            $this->fields[] = (new radio)->make('invoice')->options(['disertakan' => 'disertakan dengan barang', 'terpisah' => 'dikirim terpisah', 'email' => 'diemail', 'tidak' => 'tidak pakai']);
            $this->fields[] = (new radio)->make('jenis_pembayaran')->options(['cod' => 'cod', 'transfer' => 'transfer'])->judul('pembayaran');
            $this->fields[] = (new text)->make('jasa')->judul('jasa pengiriman');
            $this->fields[] = (new number)->make('ongkir');
            $this->fields[] = (new textarea)->make('ket_kirim')->judul('ket ongkir');


        }
    }

    public function store_proses()
    {
        request()->validate([
            'kontak_id' => 'required',
            'produk_id' => 'required',
            'jumlah' => 'required',
        ]);
  
        request()->ongkir ? $ongkir = request()->ongkir : $ongkir = 0;

        $project['kontak_id'] = request()->kontak_id;
        $project['konsumen_detail'] = request()->konsumen_detail;
        $project['total'] = request()->jumlah * request()->harga;
        $project['jasa'] = request()->jasa;
        $project['keterangan'] = request()->keterangan;
        $project['ongkir'] = $ongkir;
        $project['pengiriman'] = request()->pengiriman;
        $project['invoice'] = request()->invoice;
        $project['jenis_pembayaran'] = request()->jenis_pembayaran;
        $project['ket_kirim'] = request()->ket_kirim;
        $project['deathline'] = request()->deadline;
        $project['created_at'] = Carbon::now();
        
        //ambil data kontak 
        $kontak = kontak::find(request()->kontak_id);
        if ($kontak) {
            $project['cabang_id'] = $kontak->cabang_id;
        }else {
            $cabang = array_key_first(session('totalCabang'));
            $project['cabang_id'] = $cabang;
        }
        
        // ambil project flow setiap perusahaan
        $projectFlow = projectFlow::where('nama', 'follow up')->orWhere('nama', 'po')->first();

        $id_project = modelProject::create($project);

        //insert project detail
        $dataDetail['project_id'] = $id_project->id;
        $dataDetail['produk_id'] = request()->produk_id;
        $dataDetail['tema'] = request()->tema;
        $dataDetail['jumlah'] = request()->jumlah;
        $dataDetail['harga'] = request()->harga;
        $dataDetail['keterangan'] = request()->keterangan;
        $dataDetail['project_flow_id'] = $projectFlow->id;
        $dataDetail['deadline'] = request()->deadline;
        $dataDetail['created_at'] = Carbon::now();
        $projectDetail = projectDetail::create($dataDetail);

        $sync = [];
        $spek = spek::get();
        foreach ($spek as $spek) {
            if (request()->{$spek->nama}) {
                $sync[$spek->id] = ['keterangan' => request()->{$spek->nama}];
            }
        }
        $projectDetail->spek()->sync($sync);
        return $id_project;

    }
}
