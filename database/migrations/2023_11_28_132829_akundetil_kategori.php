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
            INSERT INTO produk_kategori_utamas (nama, beli, company_id)
            VALUES ('belanja', '1', " . $company_id. ");
        ");

        DB::statement("
            INSERT INTO produk_kategoris (nama, kategori_utama_id, company_id, id_kategori)
            (select lama_k_akundetil.nama, produk_kategori_utamas.id, produk_kategori_utamas.company_id, lama_k_akundetil.id_akundetil FROM lama_k_akundetil 
            left join produk_kategori_utamas on ( produk_kategori_utamas.company_id = " . $company_id. " and produk_kategori_utamas.nama = 'belanja')
            where lama_k_akundetil.id_akun = 6 or lama_k_akundetil.id_akun = 7 and company_id = ". $company_id. ")
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
            FROM produk_kategoris c
            left join produk_kategori_utamas on ( produk_kategori_utamas.company_id = " . $company_id. " and produk_kategori_utamas.nama = 'belanja')
            where produk_kategori_utamas.id and c.company_id = " . $company_id. ";
        ");
        DB::statement("
            DELETE FROM produk_kategori_utamas WHERE nama = 'belanja' and company_id = ". $company_id. ";
        ");
    }
};
