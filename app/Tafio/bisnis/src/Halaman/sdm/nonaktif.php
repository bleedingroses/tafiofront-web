<?php

namespace App\Tafio\bisnis\src\Halaman\sdm;
use Tafio\core\src\Library\Halaman\crud;

class nonaktif extends member
{
    public function replaceConfig()
    {
        $this->halaman     
        ->nama('member')
        ->judul('pegawai non aktif')
        ->scope('nonaktif')
        ->route('index', 'show', 'edit')
        ->linkTabs(index:$this->tab_aktif());

        if (session('cabang') != 0) {
            $this->halaman->scope('nonaktif',percabang:[session('cabang')]);
        }
    
        $this->fields['kontak->alamat']->displayFront();
        $this->fields['tempatLahir']->displayFront();
        $this->fields['kontak->noTelp']->displayFront();
        $this->fields['golonganDarah']->displayFront();
        $this->fields['statusPernikahan']->displayFront();
        $this->fields['jumlahAnak']->displayFront();
        $this->fields['tglMasuk']->displayFront();
        $this->fields['tglKeluar']->displayFront();
        $this->fields['countCuti']->displayFront=false;
        $this->fields['user->email']->displayFront=false;
        // $this->fields['gaji->last()->level->nama']->displayFront=false;
        $this->fields['countIjin']->displayFront=false;
        $this->fields['countLembur']->displayFront=false;
        $this->fields['countTunjangan']->displayFront=false;
        $this->fields['Umur']->displayFront=false;
        $this->fields['lamaKerja']->displayFront=false;
        $this->fields['tglGajian']->displayFront=false;
    }

}
