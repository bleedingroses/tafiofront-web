<?php

use Illuminate\Database\Migrations\Migration;
use Tafio\core\src\Models\company;

class ProjectCabang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $company_id = company::where('migrasi', 1)->first()->id;

        DB::statement("
            INSERT INTO project_cabangs (nama,kode,warna,rek,alamat,company_id,id_toko)
            (SELECT nama,kode,warna,rekening,alamat," . $company_id . ",id_toko from lama_toko)
        ");
    }

    public function down()
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from project_cabangs where company_id=" . $company_id);
    }
}
