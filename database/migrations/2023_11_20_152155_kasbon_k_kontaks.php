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
            INSERT INTO keuangan_kontaks (ket, total, company_id, kontak_id, jenis, kekurangan, created_at )
            (SELECT keterangan, saldo, " . $company_id . ", hrd_members.kontak_id, 'piutang', saldo, lama_kasbon.tanggal FROM lama_kasbon left join
            hrd_members on (lama_kasbon.id_pegawai = hrd_members.id_pegawai and hrd_members.company_id = " . $company_id . ") WHERE id_kasbon IN (SELECT MAX(id_kasbon) AS id_kasbon FROM lama_kasbon GROUP BY id_pegawai));
        ");

        DB::statement("
            UPDATE data_kontaks
            set saldo = ( select sum(kekurangan) FROM
            keuangan_kontaks where data_kontaks.id=keuangan_kontaks.kontak_id)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_kontaks where jenis = 'hutang' and company_id=" . $company_id);
    }
};
