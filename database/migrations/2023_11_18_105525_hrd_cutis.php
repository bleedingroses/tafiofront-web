<?php

use Tafio\core\src\Models\company;
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
            UPDATE lama_cuti
            SET jenis=1
            WHERE jenis='cuti';
        ");

        DB::statement("
            UPDATE lama_cuti
            SET jenis=0
            WHERE jenis='ijin';
        ");

        DB::statement("
            INSERT INTO hrd_cutis (tanggal, keterangan, cuti, company_id, member_id)
            (SELECT tanggal, keterangan, jenis , " . $company_id . ", hrd_members.id FROM lama_cuti left join
            hrd_members on (lama_cuti.id_pegawai=hrd_members.id_pegawai and hrd_members.company_id=" . $company_id . "))
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_cutis where company_id=" . $company_id);
    }
};
