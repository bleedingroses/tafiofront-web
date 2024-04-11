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
            INSERT INTO keuangan_kontaks ( ket, created_at, total, company_id, kontak_id, jenis, kekurangan )
            (SELECT keterangan, tanggal, total , " . $company_id.", 0, status, total - pembayaran
            FROM lama_k_hutang where total > pembayaran);
        ");

       
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_kontaks where jenis = 'order' and company_id=" . $company_id );
    }
};
