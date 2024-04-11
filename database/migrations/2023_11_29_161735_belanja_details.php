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
            INSERT INTO keuangan_belanja_details ( belanja_id, produk_id, harga, jumlah, keterangan, company_id )
            (SELECT keuangan_belanjas.id, produks.id, harga, jumlah, keterangan, keuangan_belanjas.company_id FROM lama_k_belanjadetil
            left JOIN produks ON lama_k_belanjadetil.id_barang = produks.id_bahan and produks.company_id = " . $company_id ."
            left JOIN keuangan_belanjas ON lama_k_belanjadetil.id_belanja = keuangan_belanjas.id_belanja and keuangan_belanjas.company_id = " . $company_id ."
            where keuangan_belanjas.company_id = " . $company_id .")
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_belanja_details where company_id=" . $company_id );
    }
};
