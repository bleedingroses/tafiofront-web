<?php
namespace App\Tafio\bisnis\src;

use App\Tafio\bisnis\src\Models\ar;
use App\Tafio\bisnis\src\Models\cabang;
use Tafio\core\src\Library\Resource_setting;

class setting extends Resource_setting
{
    public function navigation()
    {
        $cabang = cabang::pluck('nama','id')->toArray();

        $dataAr = ar::count();
        session(['cabang' => 0, 'totalCabang' => $cabang, 'totalAr' => $dataAr]);

        return [
            'marketing' => [
                'icon' => 'bullhorn',
                'submenu' => [
                    [
                        'nama' => 'follow up',
                        'alamat' => 'bisnis/marketing/dashboard',
                    ],
                    [
                        'nama' => 'arsip',
                        'alamat' => 'bisnis/marketing/projectMarketing',
                    ],
                    [
                        'nama' => 'kalkulator',
                        'alamat' => 'bisnis/marketing/kalkulator',
                    ],
                    [
                        'nama' => 'tinymce',
                        'alamat' => 'bisnis/marketing/tinymce',
                    ],
                ],
            ],
            'order' => [
                'icon' => 'factory',
                'submenu' => [
                    [
                        'nama' => 'proses',
                        'alamat' => 'bisnis/jasa/dashboard',
                    ],
                    [
                        'nama' => 'arsip order',
                        'alamat' => 'bisnis/jasa/project',
                    ],
                    [
                        'nama' => 'arsip produk',
                        'alamat' => 'bisnis/jasa/projectDetail',
                    ],
                    [
                        'nama' => 'komplain',
                        'alamat' => 'bisnis/jasa/komplain',
                    ],
                    [
                        'nama' => 'order minus',
                        'alamat' => 'bisnis/jasa/projectMinus',
                    ],
                    [
                        'nama' => 'marketplace',
                        'alamat' => 'bisnis/jasa/marketplace',
                    ],
                ],
            ],

            'data' => [
                'icon' => 'database',
                'submenu' => [
                    [
                        'nama' => 'kontak',
                        'alamat' => 'bisnis/data/kontak',
                    ],
                    [
                        'nama' => 'sdm',
                        'alamat' => 'bisnis/sdm/member',
                    ],                    
                    [
                        'nama' => 'ar',
                        'alamat' => 'bisnis/sdm/ar',
                    ],
                    [
                        'nama' => 'absensi',
                        'alamat' => 'bisnis/data/absensi',
                    ],
                ],
            ],

            'stok' => [
                'icon' => 'cube',
                'submenu' => [
                    [
                        'nama' => 'produk',
                        'alamat' => 'bisnis/data/kategoriUtama',
                    ],
                    [
                        'nama' => 'pemakaian',
                        'alamat' => 'bisnis/stok/pakaiStok',
                    ],
                    [
                        'nama' => 'opname',
                        'alamat' => 'bisnis/stok/produkStok',
                    ],
                    [
                        'nama' => 'produksi',
                        'alamat' => 'bisnis/stok/produksi',
                    ],
                    [
                        'nama' => 'po',
                        'alamat' => 'bisnis/stok/po',
                    ],
                    [
                        'nama' => 'analisa',
                        'alamat' => 'bisnis/stok/analisaPo',
                    ],
                ],
            ],

            'keuangan' => [
                'icon' => 'cash',
                'submenu' => [
                    [
                        'nama' => 'kas',
                        'alamat' => 'bisnis/keuangan/kas',
                    ],
                    [
                        'nama' => 'hutang/piutang',
                        'alamat' => 'bisnis/keuangan/belumlunas',
                    ],
                    [
                        'nama' => 'belanja',
                        'alamat' => 'bisnis/keuangan/belanja',
                    ],
                    [
                        'nama' => 'akun',
                        'alamat' => 'bisnis/keuangan/akunDetail',
                    ],
                ],
            ],
            'laporan' => [
                'icon' => 'file',
                'submenu' => [
                
                    [
                        'nama' => 'penggajian',
                        'alamat' => 'bisnis/laporan/penggajian',
                    ],
                   
                    [
                        'nama' => 'tunjangan',
                        'alamat' => 'bisnis/laporan/tunjangan',
                    ],
                    [
                        'nama' => 'aset',
                        'alamat' => 'bisnis/laporan/aset',
                    ],
                ],
            ],
            'statistik' => [
                'icon' => 'chart-bar',
                'submenu' => [
                    [
                        'nama' => 'omzet bulanan',
                        'alamat' => 'bisnis/jasa/omzetBulanan',
                    ],
                    [
                        'nama' => 'omzet tahunan',
                        'alamat' => 'bisnis/jasa/omzet',
                    ],
                ],
            ],
            'setting' => [
                'icon' => 'settings',
                'submenu' => [
                    [
                        'nama' => 'slider',
                        'alamat' => 'bisnis/data/slider',
                    ],
                    [
                        'nama' => 'cabang',
                        'alamat' => 'bisnis/jasa/cabang',
                    ],
                    [
                        'nama' => 'satuan',
                        'alamat' => 'bisnis/data/satuan',
                    ],
                    [
                        'nama' => 'setup pemproses',
                        'alamat' => 'bisnis/jasa/process',
                    ],
                    [
                        'nama' => 'setup produksi',
                        'alamat' => 'bisnis/jasa/projectFlow',
                    ],
                    [
                        'nama' => 'spesifikasi produk',
                        'alamat' => 'bisnis/jasa/spek',
                    ],
                    [
                        'nama' => 'level',
                        'alamat' => 'bisnis/sdm/level',
                    ],
                    [
                        'nama' => 'bagian',
                        'alamat' => 'bisnis/sdm/bagian',
                    ],
                    [
                        'nama' => 'sop',
                        'alamat' => 'bisnis/sdm/sop',
                    ],
                ],
            ],
        ];
    }

    public function config()
    {
        return
            [
            'alamat' => ['type' => 'text'],
            'rek' => ['type' => 'text'],
        ];
    }

    public function navCabang()
    {
        $data = [];
        if(count(session('totalCabang'))>1) {

            $cabang = cabang::get();
            $data = [
                0 => [
                    'nama' => 'semua cabang',
                    'alamat' => 'cabang/0',
                ],
            ];

            $awal = true;
            foreach ($cabang as $item) {

                $data[$item->id] = [
                    'nama' => $item->nama,
                    'alamat' => 'cabang/' . $item->id,
                ];
            }
        }

        return $data;
    }

}
