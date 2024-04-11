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
            INSERT INTO data_kontaks (created_at, nama, perusahaan, alamat, email, telpKantor, noTelp, konsumen, id_konsumen, company_id  )
            (SELECT pertama, contact_person, perusahaan, alamat, email, telp_kantor, hp, 1, id_konsumen,  " . $company_id . " FROM lama_konsumen)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;

        DB::statement(" delete from data_kontaks where company_id=" . $company_id . " and konsumen = 1 ");
    }
};
