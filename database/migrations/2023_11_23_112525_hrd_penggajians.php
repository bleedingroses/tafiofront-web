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
            INSERT INTO hrd_penggajians (bulan, tahun, created_at, jam_lembur, pokok, lembur, kasbon, bonus, total, lama_kerja, bagian, performance, transportasi, komunikasi, kehadiran, lain2, jumlah_lain, company_id, member_id)
            (SELECT bulan, tahun, tanggal, jam_lembur, pokok, lembur, kasbon, bonus, total, lama_kerja, bagian, performance, transportasi, komunikasi, kehadiran, lain2, jumlah_lain2, " . $company_id . ", hrd_members.id FROM lama_penggajian left join
            hrd_members on (lama_penggajian.id_pegawai=hrd_members.id_pegawai and hrd_members.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_penggajians where company_id=" . $company_id);
    }
};
