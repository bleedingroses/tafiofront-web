<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use DateTime;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\date;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\kontak;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\kontakKeuangan;
use App\Tafio\bisnis\src\Models\poDetail;
use Tafio\core\src\Library\Halaman\custom;
use App\Tafio\bisnis\src\Models\produkModel;
use App\Tafio\bisnis\src\Models\po as modelPo;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class po extends Resource
{
    use tabs,templateFields;
    public function config()
    {     
        if($this->method=='show')
        {
            $this->halaman = (new custom)->make()
            ->route('index','show','create','edit')
            ->customViewShow("custom.po.detail")
            ->judul('po detail');
            $this->po = modelPo::find(ambil('po'));

            $this->kontakKeuangan = kontakKeuangan::where("kontak_id",$this->po->kontak->id)->where('jenis','deposit')->where('detail_id',ambil('po'))->get();
        }
        else
        { 
            $this->halaman = (new crud)->make()
            ->route('index', 'show', 'create','edit')
            ->scope('proses')
            ->judul('po dalam proses')
            ->linkTabs(index:$this->tab_po());
        }

        if ($this->method=='update') {
            $this->halaman = (new crud)->make()
            ->route('index', 'show', 'create','edit')
            ->scope('proses')
            ->judul('po dalam proses')
            ->linkTabs(index:$this->tab_po());
        }

        $this->fields = [
            $this->fieldTanggal()->judul('tanggal po')->display('index'),
            $this->fieldSupplier()->search()->validate('required')->display('index','create'),
            (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk')->scope('beli')->namaField('produk_id')->validate('required')->display('create'),
            (new noForm)->make('produk')->linkShow(),
            (new number)->make('jumlah')->validate('required')->display('create'),
            (new text)->make('ket')->display('create','index','edit'),
            (new date)->make('tglKedatangan')->judul('perkiraan datang')->display('index','edit'),
            (new hidden)->make('status')->default('proses'),
            (new noForm)->make('user')->judul('user'),
        ];        
    }

    public function store_proses()
    {
        $po['kontak_id'] = request()->kontak_id;
        $po['status'] = request()->status;
        $po['ket'] = request()->ket;

        //ambil data kontak
        $kontak = kontak::find(request()->kontak_id);
        $kedatangan = $kontak->waktu_po ? Date('y:m:d', strtotime('+'.$kontak->waktu_po.' days')) : Date('y:m:d', strtotime('+7 days'));    

        $po['tglKedatangan'] = $kedatangan;

        $dataPo = modelPo::create($po);

        //insert po detail
        $dataDetail['po_id'] = $dataPo->id;
        $dataDetail['produk_id'] = request()->produk_id;
        $dataDetail['jumlah'] = request()->jumlah;
        poDetail::create($dataDetail);

        return $dataPo;
    }

    public function update_proses($hasil)
    {
        if (request()->status == 'finish') {
            $hasil->update([
                'status' => 'finish'
            ]);
            return $hasil;
        } else {
            //ambil data
            $dataPo = modelPo::find(ambil('po'));
            $kontak = kontak::find($dataPo->kontak_id);

            //update waktu kedatangan
            $dataPo->update([
                'tglKedatangan' => request()->tglKedatangan,
                'ket' => request()->ket,
            ]);
            
            return $dataPo;
        }
    }
}
