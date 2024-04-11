<?php

use Illuminate\Database\Migrations\Migration;
use Tafio\core\src\Models\company;

class HrdLevel extends Migration
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
            INSERT INTO hrd_levels (nama, gaji_pokok, komunikasi, transportasi, kehadiran, lama_kerja, id_level,company_id)
            (SELECT nama, gaji_pokok, komunikasi, transportasi, kehadiran, lama_kerja, id_level," . $company_id . " FROM lama_level)
        ");
    }

    public function down()
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_levels where company_id=" . $company_id);
    }
}
