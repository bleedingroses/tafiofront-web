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
            INSERT INTO hrd_tunjangans (ket, jumlah, saldo, created_at, company_id, member_id)
            (SELECT keterangan, pemasukan, saldo, tanggal, " . $company_id . ", hrd_members.id FROM lama_tunjangan left join
            hrd_members on (lama_tunjangan.id_pegawai=hrd_members.id_pegawai and hrd_members.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_tunjangans where company_id=" . $company_id);
    }
};
