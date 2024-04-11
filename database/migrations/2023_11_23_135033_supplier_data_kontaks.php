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
            INSERT INTO data_kontaks (nama, noTelp, alamat, ket, supplier, id_supplier, company_id )
            (SELECT nama, telp, alamat, keterangan, 1, id_supplier,  " . $company_id . " FROM lama_k_supplier)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from data_kontaks where company_id=" . $company_id . " and supplier = 1 ");
    }
};
