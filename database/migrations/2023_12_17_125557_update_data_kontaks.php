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
            UPDATE data_kontaks
            set saldo = ( select sum(kekurangan) FROM
            keuangan_kontaks where data_kontaks.id=keuangan_kontaks.kontak_id) 
            where data_kontaks.company_id = " . $company_id );

        DB::statement("
            UPDATE data_kontaks
            left JOIN project_cabangs ON data_kontaks.company_id = project_cabangs.company_id 
            SET data_kontaks.cabang_id = project_cabangs.id
            WHERE cabang_id IS NULL and data_kontaks.company_id = " . $company_id);
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
