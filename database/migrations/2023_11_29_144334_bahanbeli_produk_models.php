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
            INSERT INTO produk_models (id_produk_model, nama, harga, satuan, beli, kategori_id, company_id )
            (SELECT id_bahanbeli, lama_k_bahanbeli.nama, harga, satuan, 1, produk_kategoris.id,  " . $company_id . " FROM lama_k_bahanbeli left join
            produk_kategoris on (lama_k_bahanbeli.akun = produk_kategoris.id_kategori and produk_kategoris.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_models where beli = 1 and company_id=" . $company_id );
    }
};
