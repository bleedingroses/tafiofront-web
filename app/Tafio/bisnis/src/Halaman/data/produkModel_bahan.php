<?php

namespace App\Tafio\bisnis\src\Halaman\data;

use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\tabs;
use Tafio\core\src\Library\Field\text;
use App\Tafio\bisnis\src\Models\produk;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use App\Tafio\bisnis\src\Models\produkModel;
use Tafio\core\src\Library\Field\autocomplete;
use App\Tafio\bisnis\src\Library\templateFields;

class produkModel_bahan extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $this->halaman = (new crud)->make()
        ->linkTabs(index:$this->tab_produkModel())
        ->route('index','create','edit')
        ->orderBy('id')
        ->popup();

        $produkModel = produkModel::find(ambil("produkModel"));

        $this->fields = [
            (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk')->namaField('produk_id')->scope('stok')->validate('required'),
            (new text)->make('jumlah')->validate('required')->display("create"),
            (new noForm)->make('bahan()->first()->pivot->jumlah')->judul('jumlah'),
        ];

        if ($this->method == 'edit') {
            $produk = produk::find(ambil("bahan"));
            $this->fields = [
                (new autocomplete)->make('namaLengkap')->judul('produk')->model('bisnis.produk')->namaField('produk_id')->scope('bahan')->validate('required'),
                (new text)->make('jumlah')->validate('required')->defaultEdit($produk->bahan()->first()->pivot->jumlah),
            ];
        }
    }

    public function store_proses() 
    {
        $produkModel = produkModel::find(ambil("produkModel"));
        $produkModel->bahan()->attach(request()->produk_id, ['jumlah' => request()->jumlah]);
    }

    public function update_proses($hasil) 
    {
        $produkModel = produkModel::find(ambil("produkModel"))->bahan()->where('produk_id', ambil("bahan"))->first();
        $produkModel->bahan()->updateExistingPivot(ambil("produkModel"), [
            'jumlah' => request()->jumlah,
            'produk_id' => request()->produk_id
        ]);
    }

}
