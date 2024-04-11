<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\templateFieldsproject as modelProject;
use App\Tafio\bisnis\src\Models\projectDetail;
use App\Tafio\bisnis\src\Models\projectFlow;
use App\Tafio\bisnis\src\Models\spek;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Library\templateFields;
use Illuminate\Support\Carbon;
use Session;
use Tafio\core\src\Library\Field\autocomplete;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\radio;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Field\text;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Resource;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Halaman\custom;
use App\Tafio\bisnis\src\Models\process;
class projectMinus extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make('project')
        ->route('index', 'edit', 'create','show');

    if($this->method=='index'){
        
        $this->halaman->judul('arsip order')
        ->scope('search','kurang')
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
            $this->fieldProduk()->scope('jual')->search('noField','noQuery'),
            (new noForm)->make('listproduk')->judul('Order')->linkShow(),
            (new noForm)->make('total')->uang()->judul("Total"),
            (new noForm)->make('keuangan->kekurangan')->uang()->judul('kekurangan')->linkPopup('bisnis/data/keuangan/{keuangan->id}/keuanganDetail'),
        ];
    }

    else if ($this->method == 'show') 
    {
        $this->projects = modelProject::find(ambil("projectMinus"));
        $this->halaman=(new custom)->make()->haveShow()
        ->customViewShow("custom.jasa.projectDetail")->
        judul('project detail')->
        linkTabs(show:$this->tab_project())->popUp();

        //semua data di halaman
        $this->proses_list = process::get()->pluck('nama', 'id');
        $this->proses = process::get();
        $this->projectFlowProduksi = projectFlow::where('grup','!=','stok')->orderBy('urutan')->get()->pluck('nama', 'id');
        $this->projectFlowStok = projectFlow::where('grup','!=','produksi')->orderBy('urutan')->get()->pluck('nama', 'id');
        
        // dd($this->projectFlowStok);
        
        $this->jadwal = projectFlow::Grup('produksi')->Jadwal()->get();
    }
        
        else if ($this->method == 'edit') {
            $this->halaman->popUp();
            $this->fields = [
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
                $this->fieldProduk()->scope('jual')->search()->validate('required'),
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
            $this->fields[] = $this->fieldCabang();

            
            
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
        $project['cabang_id'] = request()->cabang_id;

        // ambil project flow setiap perusahaan
        $projectFlow = projectFlow::where('nama', 'follow up')->first();

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
