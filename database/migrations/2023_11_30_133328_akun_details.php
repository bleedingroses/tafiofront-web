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
            INSERT INTO akun_details ( id_akundetil, nama, no_akun, saldo, company_id )
            (SELECT id_akundetil, nama, id_akun, saldo, " . $company_id . " FROM lama_k_akundetil  where id_akun != 6 and id_akun != 7)
        ");

        DB::statement("
            UPDATE akun_details
            SET akun_kategori_id = 101
            WHERE no_akun = 1 and company_id= " . $company_id . ";
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from akun_details where company_id=" . $company_id );
    }
};
