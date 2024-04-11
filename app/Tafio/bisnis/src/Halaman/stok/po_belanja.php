<?php

namespace App\Tafio\bisnis\src\Halaman\stok;

use App\Tafio\bisnis\src\Models\akunDetail;
use App\Tafio\bisnis\src\Models\belanja;
use App\Tafio\bisnis\src\Models\kontakKeuangan;
use App\Tafio\bisnis\src\Models\po;
use App\Tafio\bisnis\src\Models\poDetail;
use App\Tafio\bisnis\src\Models\produk;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Halaman\crud;
use Tafio\core\src\Library\Resource;

class po_belanja extends Resource
{
    public function config()
    {
        $this->kas = akunDetail::kas()->get();
        $this->link = 'bisnis/stok/po/' . ambil('po') . '/belanja';
        $this->po = po::find(ambil('po'));
        $this->halaman = (new crud)->make('po_belanja')
            ->route('index')
            ->judul(...['po', 'biaya'])
            ->popup()
            ->customForm('custom.po.formpo')
            ->redirect('bisnis/stok/po/' . ambil('po'));

        if ($this->po->status == 'proses') {
            $this->halaman->route('index', 'create', 'destroy');
        }

        $deposit = kontakKeuangan::where("kontak_id", $this->po->kontak->id)->where('jenis', 'deposit')->where('detail_id',ambil('po'))->get();
        $this->totalDeposit = 0;
        foreach ($deposit as $value) {
            $this->totalDeposit += $value->kekurangan;
        }
    }

    public function store_proses()
    {
        request()->validate([
            'harga.*' => 'required_if_accepted:jumlah.*',
            'diskon' => 'lte:total|nullable',
            'pembayaran' => 'lte:total',
        ]);

        DB::transaction(function () {
            if (count(session('totalCabang')) > 1) {
                $cabang = request()->cabang_id;
            } else {
                $cabang = array_key_first(session('totalCabang'));
            }

            $po = po::find(ambil('po'));

            $total = request()->total;
            //insert into belanja table
            if ($total > 0) {
                $belanja = belanja::create([
                    'nota' => request()->nota ? request()->nota : rand(1000000, 100),
                    'diskon' => (request()->diskon ?? 0),
                    'total' => $total,
                    'kontak_id' => $po->kontak_id,
                    'akun_detail_id' => request()->akun_detail_id,
                    'tanggal_beli' => date("Y-m-d"),
                ]);
            }

            foreach (request()->barang_beli_id as $item => $v) {
                if ($v != null and request()->jumlah[$item] > 0 and request()->harga[$item] > 0) {
                    $harga = request()->harga[$item];
                    $jumlah = request()->jumlah[$item];
                    $belanja->belanjaDetail()->create([
                        'produk_id' => request()->barang_beli_id[$item],
                        'harga' => $harga,
                        'jumlah' => $jumlah,
                        'keterangan' => request()->keterangan[$item],
                    ]);

                    $produk = produk::find(request()->barang_beli_id[$item]);

                    // khusus barang yg ada stoknya
                    if ($produk->produkModel->stok === 1) {
                        //update hpp
                        $total = $produk->stokTotal();
                        if ($total > 0) {
                            $hpp = (($total * $produk->hpp) + ($harga * $jumlah)) / ($jumlah + $total);
                        } else {
                            $hpp = $harga;
                        }

                        $produk->update(['hpp' => $hpp]);
                        //tambah stok
                        $produk->ProdukStok()->create([
                            'tambah' => $jumlah,
                            'kurang' => 0,
                            'keterangan' => 'belanja nota:' . $belanja->nota,
                            'kode' => 'belanja',
                            'cabang_id' => $cabang,
                        ]);
                    }

                    //update jumlah kedatangan
                    $poDetail = poDetail::where('po_id', ambil('po'))->where('produk_id', request()->barang_beli_id[$item])->first();
                    $total = $poDetail->jumlahKedatangan + $jumlah;
                    $poDetail->update([
                        'jumlahKedatangan' => $total,
                    ]);
                }
            }

            if ($belanja) {
                //belanja po sync
                $belanja->po()->sync(ambil('po'));

                //belanja po sync
                $keuangan = [
                    'total' => $belanja->total,
                    'ket' => 'belanja invoice: ' . $belanja->id,
                    'jenis' => 'belanja',
                    'kontak_id' => $belanja->kontak_id,
                ];

                $hasil = $belanja->keuangan()->create($keuangan);

                $po = po::find(ambil('po'));
                if (request()->akun_detail_id and request()->pembayaran > 0) {
                    $hasil->keuanganDetail()->create(['akun_detail_id' => request()->akun_detail_id, 'jumlah' => request()->pembayaran]);
                }
                if (request()->deposit > 0) {
                    $hasil->keuanganDetail()->create(['jumlah' => request()->deposit],);

                    //update kontak keuangan
                    $deposit = kontakKeuangan::where("detail_id", ambil('po'))->where('jenis', 'deposit')->get();
                    foreach ($deposit as $value) {
                        if ($value->kekurangan - request()->deposit > 0 ) {
                            $value->keuanganDetail()->create(['jumlah' => request()->deposit, 'ket' => 'deposit terpakai']);
                        }
                        if (request()->deposit >= $value->kekurangan) {
                            $value->keuanganDetail()->create(['jumlah' => $value->kekurangan, 'ket' => 'deposit terpakai']);
                        }
                    }
                }
            }
        });

        return ambil('po');

    }

}
