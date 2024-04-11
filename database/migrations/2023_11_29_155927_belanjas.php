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
            INSERT INTO keuangan_belanjas ( id_belanja, kontak_id, nota, diskon, total, created_at, tanggal_beli, company_id )
            (SELECT id_belanja, data_kontaks.id, nota, diskon, total, tanggal_input, tanggal, " . $company_id . " FROM lama_k_belanja 
            left JOIN data_kontaks on (lama_k_belanja.id_supplier = data_kontaks.id_supplier and data_kontaks.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_belanjas where company_id=" . $company_id );
    }
};
