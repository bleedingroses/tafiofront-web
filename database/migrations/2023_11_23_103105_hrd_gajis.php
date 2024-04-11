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
            UPDATE lama_gaji
            SET transportasi = 1
            WHERE transportasi = 'ya';
        ");

        DB::statement("
            UPDATE lama_gaji
            SET transportasi = 0
            WHERE transportasi = 'tidak'; 
        ");
        
        DB::statement("
            INSERT INTO hrd_gajis (gaji, created_at, keterangan, bagian_id, level_id, transportasi, performance, lain2, jumlah_lain, company_id, member_id)
            (SELECT gaji, tanggal, keterangan, hrd_bagians.id, hrd_levels.id, lama_gaji.transportasi, performance, lain2, jumlah_lain2, " . $company_id . ", hrd_members.id FROM lama_gaji
            left JOIN hrd_bagians ON lama_gaji.bagian = hrd_bagians.id_bagian and hrd_bagians.company_id=" . $company_id . "
            left JOIN hrd_levels ON lama_gaji.level = hrd_levels.id_level and hrd_levels.company_id=" . $company_id . "
            left JOIN hrd_members ON (lama_gaji.id_pegawai = hrd_members.id_pegawai and hrd_members.company_id=" . $company_id . "));
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_gajis where company_id=" . $company_id);
    }
};
