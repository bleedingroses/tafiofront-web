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
            INSERT INTO produks (status, produk_model_id, id_bahan, company_id )
            (SELECT 1, produk_models.id, produk_models.id_produk_model, " . $company_id . " FROM produk_models
            where beli = 1 and jual is null and company_id = " . $company_id . "  )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement("
            DELETE c
            FROM produks c
            left join produk_models on c.produk_model_id = produk_models.id
            where c.company_id = " . $company_id. ";
        ");
    }
};
