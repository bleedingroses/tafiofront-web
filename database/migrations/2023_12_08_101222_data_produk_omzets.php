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
            INSERT INTO produk_omzets ( cabang_id, produk_id, omzet, jumlah, tanggal, company_id )
            (select project_cabangs.id, produks.id, omzet, jumlah, tanggal, " . $company_id ." FROM lama_omzet
            left JOIN project_cabangs ON (lama_omzet.id_toko = project_cabangs.id_toko and project_cabangs.company_id = " . $company_id .")
            left JOIN produks ON lama_omzet.id_produk = produks.id_produk and produks.company_id = " . $company_id ."
            where produks.company_id = " . $company_id .")
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_omzets where company_id=" . $company_id );
    }
};
