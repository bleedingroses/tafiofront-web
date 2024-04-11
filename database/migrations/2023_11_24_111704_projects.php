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
            INSERT INTO projects ( created_at, deathline, total, pembayaran, diskon, ket_diskon, keterangan, jasa, ongkir, ket_kirim, pengiriman, invoice, jenis_pembayaran, status_order, cabang_id, nota, konsumen_detail, id_order, kontak_id, company_id )
            (SELECT tanggal, deathline, total, pembayaran, diskon, ket_diskon, keterangan, jasa, ongkir, ket_kirim, pengiriman, invoice, jenis_pembayaran, status_order, project_cabangs.id, nota, konsumen_detail, id_order, data_kontaks.id,  " . $company_id . " FROM lama_orderx 
            left JOIN project_cabangs ON (lama_orderx.id_toko = project_cabangs.id_toko and project_cabangs.company_id=" . $company_id . ") 
            left JOIN data_kontaks on (lama_orderx.id_konsumen = data_kontaks.id_konsumen and data_kontaks.company_id=" . $company_id . "))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from projects where company_id=" . $company_id );
    }
};
