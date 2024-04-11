<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Models\cabang;
use App\Tafio\bisnis\src\Models\produksi as modelProduksi;
use App\Tafio\bisnis\src\Models\produkStok;
use Tafio\core\src\Library\Field\hidden;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\statis;
use Tafio\core\src\Library\Field\select;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Halaman\custom;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Field\autocomplete;


class produksi extends Resource
{
    use templateFields,tabs;
    public function config()
    {
        
if(request()->status=='finish')
{

   $this->fields = [
                $this->fieldTanggal(),
                (new statis)->make('produk->namaLengkap'),
                (new statis)->make('target')->judul('target produksi'),
                (new statis)->make('biaya')->judul('total biaya'),
                (new number)->make('hasil')->judul('total hasil produksi'),
                (new hidden)->make('status')->defaultEdit('finish'),
            ];
}

else {
            $this->fields = [
                $this->fieldTanggal(),
                (new autocomplete)->make('produk->namaLengkap')->model('bisnis.produk')->namaField('produk_id')->scope('produksi')->linkShow()->search()->validate('required'),
                (new number)->make('target')->judul('target produksi')->uang()->validate('required'),
                (new noForm)->make('biaya')->judul('total biaya')->display('index')->uang(),
                (new textarea)->make('ket'),
                $this->fieldCabang(),
                (new noForm)->make('user')->judul('user'),
            ];
        }

        if($this->method=='show')
        {
            $this->halaman = (new custom)->make()
            ->route('index','show','create')
            ->customViewShow("custom.produksi.index")
            ->judul('produksi detail');
            $this->produksi = modelProduksi::find(ambil('produksi'));
        }
        else
        { 
            $this->halaman = (new crud)->make()
            ->route('index','show','create','edit')
            ->scope('proses')
            ->judul('proses produksi')
            ->linkTabs(index:$this->tab_produksi());
        }

     
       
    
    }






public function after_update($model)
{

if($model->status=='finish')
{
$model->hpp=floor($model->biaya/$model->hasil);
$model->tanggal_selesai=now();

$model->save();

$produk=$model->produk;


///////////////////hitung hpp


$total=$produk->stokTotal();
if($total>0)
$hpp=(($total*$produk->hpp)+($model->hpp*$model->hasil))/($model->hasil+$total);
else
$hpp=$model->hpp;


$produk->update(['hpp'=>$hpp]);



                        $produk->ProdukStok()->create([
                            'tambah' => $model->hasil,
                            'kurang' => 0,
                            'keterangan' => 'hasil produksi',
                            'kode' => 'hasilProduksi',
                            'cabang_id' => $model->cabang_id,
                            'detail_id'=>$model->id
                        ]);





                    }
                }



}


