<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE hrd_members
            ADD column id_pegawai bigint unsigned;
        ");

        DB::statement("
            ALTER TABLE project_cabangs
            ADD column id_toko bigint unsigned;
        ");

        DB::statement("
            ALTER TABLE hrd_bagians
            ADD column id_bagian bigint unsigned;
        ");

        DB::statement("
            ALTER TABLE hrd_levels
            ADD column id_level bigint unsigned;
        ");

        DB::statement("
            ALTER TABLE data_kontaks
            ADD column id_konsumen BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE data_kontaks
            ADD column id_supplier BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produk_kategori_utamas
            ADD column id_kategori_utama BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produk_kategoris
            ADD column id_kategori BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produk_models
            ADD column id_produk_model BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produks
            ADD column id_produk BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE projects
            ADD column id_order BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE keuangan_belanjas
            ADD column id_belanja BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produks
            ADD column id_bahan BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produksis
            ADD column id_produksi BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE produk_stoks
            ADD column id_detail BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE akun_details
            ADD column id_akundetil BIGINT UNSIGNED;
        ");

        DB::statement("
            ALTER TABLE akun_buku_besars
            ADD column id_detail BIGINT UNSIGNED;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE hrd_members
            DROP column id_pegawai;
        ");

        DB::statement("
            ALTER TABLE project_cabangs
            DROP column id_toko;
        ");

        DB::statement("
            ALTER TABLE hrd_bagians
            DROP column id_bagian;
        ");

        DB::statement("
            ALTER TABLE hrd_levels
            DROP column id_level;
        ");

        DB::statement("
            ALTER TABLE data_kontaks
            DROP column id_konsumen;
        ");

        DB::statement("
            ALTER TABLE data_kontaks
            DROP column id_supplier;
        ");

        DB::statement("
            ALTER TABLE produk_kategori_utamas
            DROP column id_kategori_utama;
        ");

        DB::statement("
            ALTER TABLE produk_kategoris
            DROP column id_kategori;
        ");

        DB::statement("
            ALTER TABLE produk_models
            DROP column id_produk_model;
        ");

        DB::statement("
            ALTER TABLE produks
            DROP column id_produk;
        ");

        DB::statement("
            ALTER TABLE projects
            DROP column id_order;
        ");

        DB::statement("
            ALTER TABLE keuangan_belanjas
            DROP column id_belanja;
        ");

        DB::statement("
            ALTER TABLE produks
            DROP column id_bahan;
        ");

        DB::statement("
            ALTER TABLE produksis
            DROP column id_produksi;
        ");

        DB::statement("
            ALTER TABLE produk_stoks
            DROP column id_detail;
        ");

        DB::statement("
            ALTER TABLE akun_details
            DROP column id_akundetil;
        ");

        DB::statement("
            ALTER TABLE akun_buku_besars
            DROP column id_detail;
        ");
    }
};
