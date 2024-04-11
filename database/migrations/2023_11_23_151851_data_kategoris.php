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
            INSERT INTO produk_kategoris (nama, web, id_kategori, kategori_utama_id, company_id )
            (SELECT lama_kategori.nama, lama_kategori.web, lama_kategori.id_kategori, produk_kategori_utamas.id,  " . $company_id . " FROM lama_kategori left join
            produk_kategori_utamas on (lama_kategori.id_kategori_utama = produk_kategori_utamas.id_kategori_utama and produk_kategori_utamas.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_kategoris where company_id=" . $company_id );
    }
};
