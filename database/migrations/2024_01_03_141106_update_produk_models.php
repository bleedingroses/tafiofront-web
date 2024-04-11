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
            update produk_models set supplier_id =
            (select kontak_id from keuangan_belanjas join keuangan_belanja_details on keuangan_belanjas.id = keuangan_belanja_details.belanja_id
            join produks on produks.id = keuangan_belanja_details.produk_id where produk_models.id = produks.produk_model_id order by keuangan_belanja_details.id desc limit 1)
            where company_id = " . $company_id 
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
