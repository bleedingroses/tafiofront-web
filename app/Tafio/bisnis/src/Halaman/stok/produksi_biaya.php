<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\belanja;
use App\Tafio\bisnis\src\Models\produksi;
use App\Tafio\bisnis\src\Library\tabs;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Field\noForm;
use Tafio\core\src\Library\Field\number;
use Tafio\core\src\Library\Field\textarea;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;
use App\Tafio\bisnis\src\Library\templateFields;

class produksi_biaya extends Resource
{
    use tabs,templateFields;
    public function config()
    {
        $this->kas = akunDetail::kas()->get();
        $this->link = 'bisnis/stok/produksi/' . ambil('produksi') . '/biaya';
        $this->produksi = $produksi = produksi::find(ambil('produksi'));
        $this->halaman = (new crud)->make('produksi_belanja')
            ->route('index')
            ->judul(...['produksi', 'biaya'])
            ->linkTabs(...['index' => $this->tab_produksi()])
            ->popup()
            ->customForm('custom.produksi.formBiaya')
            ->redirect('bisnis/stok/produksi/' . ambil('produksi'));

        if ($produksi->status == 'proses') {
            $this->halaman->route('index', 'create', 'destroy');
        }

        $this->fields = [
            $this->fieldTanggal(),
            (new number)->make('kontak->namaLengkap')->judul('vendor'),
            (new number)->make('produk')->judul('jasa'),
            (new noForm)->make('diskon')->uang(),
            (new noForm)->make('total')->uang(),
            (new noForm)->make('keuangan->kekurangan')->uang()->judul('kekurangan')->linkPopup('bisnis/data/keuangan/{keuangan->id}/keuanganDetail'),
            (new textarea)->make('ket'),
        ];
    }

    public function store_proses()
    {
        request()->validate([
            'supplier_id' => 'required',
            'barang_beli_id.0' => 'required',
            'jumlah.*' => 'required_with:barang_beli_id.*',
            'diskon' => 'lte:total|nullable',
            'pembayaran' => 'lte:total',
        ]);

        DB::transaction(function () {
            if (count(session('totalCabang')) > 1) {
                $cabang = request()->cabang_id;
            } else {
                $cabang = array_key_first(session('totalCabang'));
            }

            $total = request()->total;
            //insert into belanja table
            $belanja = belanja::create([
                'nota' => request()->nota ? request()->nota : rand(1000000, 100),
                'diskon' => (request()->diskon ?? 0),
                'total' => $total,
                'kontak_id' => request()->supplier_id,
                'akun_detail_id' => request()->akun_detail_id,
                'tanggal_beli' => date("Y-m-d"),
            ]);

            foreach (request()->barang_beli_id as $item => $v) {
                if ($v != null) {

                    $belanja->belanjaDetail()->create([
                        'produk_id' => request()->barang_beli_id[$item],
                        'harga' => request()->harga[$item],
                        'jumlah' => request()->jumlah[$item],
                        'keterangan' => request()->keterangan[$item],
                    ]);

                    //belanja produksi sync
                    $belanja->produksi()->sync(ambil('produksi'));
                }
            }

            $pembayaran = request()->pembayaran;

            $keuangan = ['total' => $belanja->total, 'ket' => 'belanja invoice: ' . $belanja->id, 'jenis' => 'belanja', 'kontak_id' => $belanja->kontak_id,
            ];

            $hasil = $belanja->keuangan()->create($keuangan);

            $produksi = produksi::find(ambil('produksi'));
            if (request()->akun_detail_id and request()->pembayaran > 0) {
                $hasil->keuanganDetail()->create(['akun_detail_id' => request()->akun_detail_id, 'jumlah' => $pembayaran]);

            }

            $produksi->hitungBiaya();
        });

        return ambil('produksi');

    }

    public function after_destroy($model)
    {

        $produksi = produksi::find(ambil('produksi'));
        $produksi->hitungBiaya();

        $model->keuangan->delete();

    }
}
