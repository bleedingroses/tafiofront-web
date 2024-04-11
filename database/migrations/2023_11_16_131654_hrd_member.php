<?php

use Illuminate\Database\Migrations\Migration;
use Tafio\core\src\Models\company;

class HrdMember extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $company_id = company::where('migrasi', 1)->first()->id;

        DB::statement("
            INSERT INTO hrd_members (nama, tempatLahir, tglLahir, tglMasuk, tglKeluar, golonganDarah, statusPernikahan, jumlahAnak, tglGajian, noRekening, nik, jenisKelamin, cabang_id, id_pegawai,company_id)
            (SELECT lama_pegawai.nama, tmp_lahir, tgl_lahir, tgl_masuk, tgl_keluar, goldar, status, anak, gajian, norek, nik, kelamin, project_cabangs.id,id_pegawai, " . $company_id . " FROM lama_pegawai left join
            project_cabangs on (lama_pegawai.id_toko=project_cabangs.id_toko and project_cabangs.company_id=" . $company_id . "))
        ");

        DB::statement("
            UPDATE hrd_members
            SET aktif = 1
            where tglKeluar IS null and tglMasuk is not Null and company_id = " . $company_id . ";
        ");
    }

    public function down()
    {
        $company_id = company::where('migrasi', 1)->first()->id;
        DB::statement(" delete from hrd_members where company_id=" . $company_id);
    }
}
