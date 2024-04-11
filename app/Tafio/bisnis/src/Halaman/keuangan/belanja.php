<?php

namespace App\Tafio\bisnis\src\Halaman\keuangan;

use App\Tafio\bisnis\src\Library\tabs;
use App\Tafio\bisnis\src\Library\templateFields;
use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\belanja as model_belanja;
use App\Tafio\bisnis\src\Models\belanjaDetail;
use App\Tafio\bisnis\src\Models\produk;
use App\Tafio\bisnis\src\Models\produkModel;
use App\Tafio\bisnis\src\Models\produkStok;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class belanja extends Resource
{
    use tabs, templateFields;
    public function config()
    {
        $this->kas = akunDetail::kas()->get();
        $this->link = 'bisnis/keuangan/belanja';
        $this->halaman = (new crud)->make()
            ->route('index', 'create')
            ->scope('search')
            ->orderBy(...['created_at' => 'desc'])
            ->customForm('custom.Keuangan.formBelanja');

        $this->fields = [
            $this->fieldTanggal2()->display('index')->search()->sortable(),
            (new noForm)->make('nota'),
            $this->fieldSupplier()->search(),
            $this->fieldProduk()->search('noField', 'noQuery')->scope('beli'),
            (new noForm)->make('produk')->linkPopUp('bisnis/keuangan/belanja/{id}/belanjaDetail'),
            (new noForm)->make('diskon')->uang(),
            (new noForm)->make('total')->uang(),
            (new noForm)->make('keuangan->kekurangan')->judul('kekurangan')->uang()->linkPopup('bisnis/data/keuangan/{keuangan->id}/keuanganDetail'),
            (new noForm)->make('user')->judul('user'),
        ];
    }

    public function store_proses()
    {

// dd(request()->all());

        request()->validate([
            'supplier_id' => 'required',
            'barang_beli_id.0' => 'required',
            'jumlah.*' => 'required_with:barang_beli_id.*',
            'diskon' => 'lte:total|nullable',
            'pembayaran' => 'lte:total',
        ]);

        DB::transaction(function () {

////////////////////////input belanja/////////////////////////////////////////////////////////////////////

            if (count(session('totalCabang')) > 1) {
                $cabang = request()->cabang_id;
            } else {
                $cabang = array_key_first(session('totalCabang'));
            }

            $total = request()->total;
            //insert into belanja table
            $belanja = model_belanja::create([
                'nota' => request()->nota ? request()->nota : rand(1000000, 100),
                'diskon' => (request()->diskon ?? 0),
                'total' => $total,
                'kontak_id' => request()->supplier_id,
                'akun_detail_id' => request()->akun_detail_id,
                'tanggal_beli' => request()->tanggal,
            ]);

            foreach (request()->barang_beli_id as $item => $v) {
                if ($v != null) {

                    $harga = request()->harga[$item];
                    $jumlah = request()->jumlah[$item];

                    $belanja->belanjaDetail()->create([
                        'produk_id' => request()->barang_beli_id[$item],
                        'harga' => $harga,
                        'jumlah' => $jumlah,
                        'keterangan' => request()->keterangan[$item],
                    ]);

                    $produk = produk::find(request()->barang_beli_id[$item]);

//////////////////////////khusus barang yg ada stoknya
                    if ($produk->produkModel->stok === 1) {

//////////////////////////update hpp//////////////////
                        $total = $produk->stokTotal();

                        if ($total > 0) {
                            $hpp = (($total * $produk->hpp) + ($harga * $jumlah)) / ($jumlah + $total);
                        } else {
                            $hpp = $harga;
                        }

                        $produk->update(['hpp' => $hpp]);

//////////////////////////tambah stok//////////////////

                        $produk->ProdukStok()->create([
                            'tambah' => $jumlah,
                            'kurang' => 0,
                            'keterangan' => 'belanja nota:' . $belanja->nota,
                            'kode' => 'belanja',
                            'cabang_id' => $cabang,
                        ]);

                    }
                }
            }

//////////////////input tagihan/////////////////////////////////////////////////////////////////////
            $pembayaran = request()->pembayaran;

            $keuangan = ['total' => $belanja->total, 'ket' => 'belanja invoice: ' . $belanja->id, 'jenis' => 'belanja', 'kontak_id' => $belanja->kontak_id,
            ];

            $hasil = $belanja->keuangan()->create($keuangan);

            //// jika ada pembayaran jika ada
            if (request()->akun_detail_id and request()->pembayaran > 0) {
                $hasil->keuanganDetail()->create(['akun_detail_id' => request()->akun_detail_id, 'jumlah' => $pembayaran]);
            }

        });
    }
}
