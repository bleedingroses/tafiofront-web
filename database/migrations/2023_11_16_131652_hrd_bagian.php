<?php

use Illuminate\Database\Migrations\Migration;
use Tafio\core\src\Models\company;

class HrdBagian extends Migration
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
            INSERT INTO hrd_bagians (nama,grade,id_bagian,company_id)
            (SELECT nama,grade,id_bagian," . $company_id . " FROM lama_bagian);
        ");
    }

    public function down()
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_bagians where company_id=" . $company_id);
    }
}
