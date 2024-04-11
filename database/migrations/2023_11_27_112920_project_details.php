<?php

use Tafio\core\src\Models\company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Tafio\bisnis\src\Models\projectFlow;
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
            INSERT INTO project_details ( project_id, produk_id, tema, jumlah, harga, keterangan,  company_id )
            (select projects.id, produks.id, tema, jumlah, harga, lama_orderx.keterangan,  projects.company_id FROM lama_orderdetil
            left JOIN lama_orderx ON lama_orderdetil.id_order = lama_orderx.id_order
            left JOIN produks ON lama_orderdetil.barang = produks.id_produk and produks.company_id = " . $company_id ."
            left JOIN projects ON lama_orderdetil.id_order = projects.id_order 
            where projects.company_id = " . $company_id .")
        ");

        DB::statement("
            UPDATE project_details
            left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
            left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
            left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
            left JOIN project_flows on lama_orderx.status = project_flows.nama and project_flows.company_id = " . $company_id ."
            SET project_details.project_flow_id = project_flows.id
            WHERE lama_orderx.status = 'po' and project_details.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE project_details
            left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
            left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
            left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
            left JOIN project_flows on lama_orderx.status = project_flows.nama and project_flows.company_id = " . $company_id ."
            SET project_details.project_flow_id = project_flows.id
            WHERE lama_orderx.status = 'finish' and project_details.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE project_details
            left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
            left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
            left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
            left JOIN project_flows on lama_orderx.status = project_flows.nama and project_flows.company_id = " . $company_id ."
            SET project_details.project_flow_id = project_flows.id
            WHERE lama_orderx.status = 'batal' and project_details.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE project_details
            left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
            left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
            left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
            left JOIN project_flows on lama_orderx.status = project_flows.nama and project_flows.company_id = " . $company_id ."
            SET project_details.project_flow_id = project_flows.id
            WHERE lama_orderx.status = 'proses' and lama_orderdetil.proses = 'proses' and project_details.company_id = " . $company_id .";
        ");

        DB::statement("
            UPDATE project_details
            left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
            left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
            left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
            left JOIN project_flows on lama_orderdetil.proses = project_flows.nama and project_flows.company_id = " . $company_id ."
            SET project_details.project_flow_id = project_flows.id
            WHERE lama_orderx.status = 'proses' and lama_orderdetil.proses = 'siap' and project_details.company_id = " . $company_id .";
        ");

        $flow = projectFlow::get();
        if ($flow) {
            foreach ($flow as $value) {
                DB::statement("
                UPDATE project_details
                left JOIN projects ON project_details.project_id = projects.id and projects.company_id = " . $company_id ."
                left JOIN lama_orderx ON projects.id_order = lama_orderx.id_order
                left JOIN lama_orderdetil ON lama_orderx.id_order = lama_orderdetil.id_order
                left JOIN project_flows on lama_orderdetil.proses = project_flows.nama and project_flows.company_id = " . $company_id ."
                SET project_details.project_flow_id = project_flows.id
                WHERE lama_orderx.status = 'proses' and lama_orderdetil.proses = '" . $value->nama ."' and project_details.company_id = " . $company_id .";
            ");
            }
        }

        DB::statement("
            DELETE FROM project_details WHERE produk_id IS NULL and company_id = " . $company_id .";
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from project_details where company_id=" . $company_id );
    }
};
