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
            INSERT INTO akun_buku_besars ( id_detail, akun_detail_id, created_at, kode, ket, debet, kredit, saldo, company_id )
            (SELECT lama_k_bukubesar.id_detail, akun_details.id, tanggal, kode, ket, debet, kredit, lama_k_bukubesar.saldo, " . $company_id . " FROM lama_k_bukubesar
            left JOIN akun_details ON lama_k_bukubesar.id_akun = akun_details.id_akundetil and akun_details.company_id = " . $company_id .")
        ");

        DB::statement("
            DELETE FROM akun_buku_besars WHERE akun_detail_id IS NULL and company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE akun_buku_besars
            left JOIN projects ON akun_buku_besars.id_detail = projects.id_order and projects.company_id=".$company_id."
            SET akun_buku_besars.detail_id = projects.id
            WHERE akun_buku_besars.kode = 'byr' and akun_buku_besars.company_id=".$company_id." and projects.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE akun_buku_besars
            left JOIN keuangan_belanjas ON akun_buku_besars.id_detail = keuangan_belanjas.id_belanja and keuangan_belanjas.company_id=".$company_id."
            SET akun_buku_besars.detail_id = keuangan_belanjas.id
            WHERE akun_buku_besars.kode = 'blj' and akun_buku_besars.company_id=".$company_id."  and keuangan_belanjas.company_id = " . $company_id .";
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from akun_buku_besars where company_id=" . $company_id );
    }
};
