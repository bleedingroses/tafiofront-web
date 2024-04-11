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
            INSERT INTO produk_models (id_produk_model, nama, harga, satuan, gambar, deskripsi, modal, discontinue, web, jual, stok, beli, produksi, kategori_id, company_id )
            (SELECT id_produk_model, lama_produk_model.nama, jual, satuan, gambar, deskripsi, modal, discontinue, lama_produk_model.web, 1, 1, 1, 1, produk_kategoris.id,  " . $company_id . " FROM lama_produk_model left join
            produk_kategoris on (lama_produk_model.id_kategori = produk_kategoris.id_kategori and produk_kategoris.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_models where company_id=" . $company_id );
    }
};
