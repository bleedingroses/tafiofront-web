<?php

use Tafio\core\src\Models\company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;

        DB::statement("
            INSERT INTO project_flows (nama, warna, urutan, grup_id, company_id)
            VALUES ('po', '#000000', '1', '1',  " . $company_id. ");
        ");
        DB::statement("
            INSERT INTO project_flows (nama, warna, urutan, grup_id, company_id)
            VALUES ('proses', '#000000', '2', '2',  " . $company_id. ");
        ");
        DB::statement("
            INSERT INTO project_flows (nama, warna, urutan, grup_id, company_id)
            VALUES ('siap', '#000000', '3', '4',  " . $company_id. ");
        ");        
        DB::statement("
            INSERT INTO project_flows (nama, warna, urutan, grup_id, company_id)
            VALUES ('finish', '#000000', '4', '6',  " . $company_id. ");
        ");
        DB::statement("
            INSERT INTO project_flows (nama, warna, urutan, grup_id, company_id)
            VALUES ('batal', '#000000', '5', '5',  " . $company_id. ");
        ");
        DB::statement("
            INSERT INTO project_flows (nama, warna, grup_id, company_id)
            (SELECT kode_proses, warna, 2,  " . $company_id . " FROM lama_proses)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from project_flows where company_id=" . $company_id);
    }
};
