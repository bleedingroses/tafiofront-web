<?php

namespace app\Tafio\bisnis\src\Library;

use App\Tafio\bisnis\src\Models\kategori;
use App\Tafio\bisnis\src\Models\produksi;
use App\Tafio\bisnis\src\Models\produkModel;

trait tabs
{

    public function tab_piutang()
    {
        return [
            'order' => 'bisnis/keuangan/belumlunas',
            'belanja' => 'bisnis/keuangan/belumlunas?jenis=belanja',
            'hutang' => 'bisnis/keuangan/belumlunas?jenis=hutang',
            'piutang' => 'bisnis/keuangan/belumlunas?jenis=piutang',
        ];
    }
    public function tab_belanja()
    {
        return [
            'semua' => 'bisnis/keuangan/belanja',
            'belum lunas' => 'bisnis/keuangan/belanjaBelumLunas',
        ];
    }

    public function tab_akun()
    {
        return [
            'akun' => 'bisnis/keuangan/akun',
            'akun kategori' => 'bisnis/keuangan/akunKategori',
            'akun detail' => 'bisnis/keuangan/akunDetail',
        ];
    }

    public function tab_hutang()
    {
        return [
            'hutang' => 'bisnis/keuangan/hutang',
            'piutang' => 'bisnis/keuangan/piutang',
        ];
    }

    public function tab_aktif()
    {
        return [
            'pegawai aktif' => 'bisnis/sdm/member',
            'pegawai nonaktif' => 'bisnis/sdm/nonaktif',
        ];
    }

    public function tab_produksi()
    {
        return [
            'proses' => 'bisnis/stok/produksi',
            'arsip' => 'bisnis/stok/produksiArsip',
        ];
    }

    public function tab_po()
    {
        return [
            'proses' => 'bisnis/stok/po',
            'arsip' => 'bisnis/stok/arsipPo',
        ];
    }

    public function tab_analisa()
    {
        return [
            'po' => 'bisnis/stok/analisaPo',
            // 'stok telat' => 'bisnis/stok/analisaStokTelat',
            'over stok' => 'bisnis/stok/analisaOverStok',
            'tdk aktif' => 'bisnis/stok/analisaNonAktif',
        ];
    }
    public function tab_project()
    {
        $this->project = ambil('project');
        return [
            'detail' => 'bisnis/jasa/project/' . $this->project,
            'pengiriman' => 'bisnis/jasa/project/' . $this->project . '/projectKurir',
            'komplain' => 'bisnis/jasa/project/' . $this->project . '/projectKomplain',
        ];
    }

    public function tab_produk()
    {
        return [
            'aktif' => 'bisnis/data/kategoriUtama/' . ambil('kategoriUtama') . '/kategori/' . ambil('kategori') . '/produkModel',
            'non aktif' => 'bisnis/data/kategoriUtama/' . ambil('kategoriUtama') . '/kategori/' . ambil('kategori') . '/produkNonAktif',
            'omzet' => 'bisnis/laporan/aset/' . ambil('kategori') . '/produk',
        ];
    }

    public function tab_aset()
    {
        $kategori = kategori::find(ambil('aset'));
        return [
            'omzet' => 'bisnis/laporan/aset/' . ambil('aset') . '/produk',
            'aktif' => 'bisnis/data/kategoriUtama/' . $kategori->kategori_utama_id . '/kategori/' . ambil('aset') . '/produkModel',
            'non aktif' => 'bisnis/data/kategoriUtama/' . $kategori->kategori_utama_id . '/kategori/' . ambil('aset') . '/produkNonAktif',
        ];
    }

    public function tab_produkModel()
    {
        if (ambil('produkModel')) {
            $produk = produkModel::find(ambil('produkModel'));
            $link = [
                'detail' => 'bisnis/data/kategoriUtama/' . $produk->kategori->kategori_utama_id . '/kategori/' . $produk->kategori_id . '/produkModel/' . ambil('produkModel') . '',
                'varian' => 'bisnis/data/produkModel/' . ambil('produkModel') . '/produk',
            ];

            return $link;
        }
    }

    public function tab_sop()
    {
        return [
           'peraturan' => 'bisnis/sdm/sop',
           'marketing' => 'bisnis/sdm/sop?jenis=marketing',
           'order' => 'bisnis/sdm/sop?jenis=order',
        ];
    }

}
