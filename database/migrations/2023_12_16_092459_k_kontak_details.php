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
            INSERT INTO keuangan_kontak_details (keuangan_id, jumlah, created_at, ket, company_id )
            (select keuangan_kontaks.id, projects.pembayaran, keuangan_kontaks.created_at, 'pembayaran', " . $company_id ." FROM keuangan_kontaks
            left JOIN projects ON keuangan_kontaks.detail_id = projects.id and projects.company_id = " . $company_id ."
            where keuangan_kontaks.company_id = " . $company_id ." and jenis = 'order' and projects.pembayaran != 0
            )            
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_kontak_details where company_id=" . $company_id );
    }
};
