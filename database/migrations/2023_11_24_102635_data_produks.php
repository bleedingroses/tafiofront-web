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
            UPDATE lama_produk
            SET status=1
            WHERE status='aktif'; 
        ");

        DB::statement("
            UPDATE lama_produk
            SET status=0
            WHERE status='tidak';
        ");

        DB::statement("
            INSERT INTO produks (id_produk, nama, hpp, status, produk_model_id, company_id )
            (SELECT lama_produk.id_produk, lama_produk.varian, lama_produk.hpp, lama_produk.status, produk_models.id,  " . $company_id . " FROM lama_produk left join
            produk_models on (lama_produk.id_produk_model = produk_models.id_produk_model and produk_models.company_id=" . $company_id . "))
        ");
        
        DB::statement("
            DELETE FROM produks WHERE produk_model_id IS NULL;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produks where company_id=" . $company_id );
    }
};
