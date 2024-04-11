<?php

use Illuminate\Database\Migrations\Migration;
use Tafio\core\src\Models\company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;

        DB::statement("
            INSERT INTO data_kontaks (nama, alamat, noTelp, email, company_id, lainnya, id_member)
            (SELECT lama_pegawai.nama, lama_pegawai.alamat, lama_pegawai.telp, lama_pegawai.email, " . $company_id . " , 1, id FROM hrd_members left join
            lama_pegawai on (hrd_members.id_pegawai = lama_pegawai.id_pegawai ) where company_id = " . $company_id . ");
        ");

        DB::statement("
            update hrd_members
            join (
                select id, id_member
                from data_kontaks) as queryx on
                hrd_members.id = queryx.id_member set
                hrd_members.kontak_id = queryx.id where company_id = " . $company_id . "
        ");        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from data_kontaks where company_id=" . $company_id);
    }
};
