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
            INSERT INTO produk_produksis (id_produksi, status, biaya, hasil, target, hpp, ket, created_at, cabang_id, produk_id, company_id )
            (SELECT lama_produksi.id_produksi, lama_produksi.status, biaya, hasil, target, lama_produksi.hpp, ket, tanggal,  project_cabangs.id, produks.id,  " . $company_id . " FROM lama_produksi 
            left JOIN project_cabangs ON (lama_produksi.id_toko = project_cabangs.id_toko and project_cabangs.company_id=" . $company_id . ")
            left JOIN produks on (lama_produksi.id_produk = produks.id_produk and produks.company_id=" . $company_id . "))
        ");

        DB::statement("
            UPDATE produk_produksis
            SET status = 'proses'
            WHERE status = 'belum' and company_id= " . $company_id . ";
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_produksis where company_id=" . $company_id );
    }
};
