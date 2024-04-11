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
            INSERT INTO keuangan_kontaks (created_at, ket, total, company_id, kontak_id, detail_id, jenis, kekurangan )
            (SELECT created_at, lama_orderx.keterangan, lama_orderx.total, " . $company_id . ", projects.kontak_id, projects.id, 'order', lama_orderx.total - lama_orderx.pembayaran FROM lama_orderx join
            projects on (lama_orderx.id_order = projects.id_order and projects.company_id=" . $company_id . ") WHERE lama_orderx.total > (lama_orderx.pembayaran+lama_orderx.diskon));
        ");
 
 
        DB::statement("
            INSERT INTO keuangan_kontaks (created_at, ket, total, kontak_id, detail_id, jenis, kekurangan, company_id)
            (select projects.created_at, concat('order invoice :',projects.id), projects.total, projects.kontak_id, projects.id,'order', projects.total - projects.pembayaran, " . $company_id ." FROM projects
            join project_details ON projects.id = project_details.project_id and project_details.company_id = " . $company_id ."
            join project_flows ON project_details.project_flow_id = project_flows.id and project_flows.company_id = " . $company_id ."
            join project_grups ON project_flows.grup_id = project_grups.id 
            where project_grups.nama != 'batal' and project_grups.nama != 'finish' and projects.pembayaran = projects.total and projects.total != 0
            group by projects.id)
        ");

     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from keuangan_kontaks where jenis = 'order'  and company_id=" . $company_id );
    }
};
