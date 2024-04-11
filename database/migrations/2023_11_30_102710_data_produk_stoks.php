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
            INSERT INTO produk_stoks ( id_detail, created_at, tambah, kurang, saldo, keterangan, kode, cabang_id, produk_id, company_id )
            (SELECT lama_produkstok.id_detail, lama_produkstok.tanggal, tambah, kurang, lama_produkstok.saldo, keterangan, lama_produkstok.kode, project_cabangs.id, produks.id,  " . $company_id . " FROM lama_produkstok 
            left JOIN project_cabangs ON lama_produkstok.id_toko = project_cabangs.id_toko and project_cabangs.company_id=" . $company_id . "
            left JOIN produks on (lama_produkstok.id_stok = produks.id_produk and produks.company_id=" . $company_id . "))
        ");

        DB::statement("
            UPDATE produk_stoks
            left JOIN projects ON produk_stoks.id_detail = projects.id_order and projects.company_id = " . $company_id ."
            SET produk_stoks.detail_id = projects.id
            WHERE produk_stoks.kode = 'djl' and projects.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'bahanProduksi'
            WHERE kode = 'bhn' and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'jual'
            WHERE kode = 'djl' and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'opname'
            WHERE kode = 'opn'and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'belanja'
            WHERE kode = 'blj'and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'pindah'
            WHERE kode = 'pdh'and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            SET kode = 'hasilProduksi'
            WHERE kode = 'prd'and company_id= " . $company_id . ";
        ");

        DB::statement("
            UPDATE produk_stoks
            left JOIN project_cabangs ON produk_stoks.company_id = project_cabangs.company_id 
            SET produk_stoks.cabang_id = project_cabangs.id
            WHERE cabang_id IS NULL and data_kontaks.company_id = " . $company_id);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from produk_stoks where company_id=" . $company_id );
    }
};
