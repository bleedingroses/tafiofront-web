<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;

class member extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "hrd_members";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function kontak()
    {
        return $this->belongsTo(kontak::class);
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }

    public function scopePercabang($query, $id)
    {
        return $query->where('cabang_id', $id);
    }

    public function tunjangan()
    {
        return $this->hasMany(tunjangan::class);
    }

    public function gaji()
    {
        return $this->hasMany(gaji::class);
    }

    public function penggajian()
    {
        return $this->hasMany(penggajian::class);
    }

    public function cuti()
    {
        return $this->hasMany(cuti::class);
    }

    public function ar()
    {
        return $this->hasOne(ar::class);
    }

    public function lembur()
    {
        return $this->hasMany(lembur::class);
    }
    public function keuangan()
    {
        return $this->kontak->keuangan();
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function absen()
    {
        return $this->hasMany(absensi::class);
    }

    public function user()
    {
        return $this->belongsTo("Tafio\core\src\Models\User");
    }

    public function scopeAktif($query)
    {
        $query->where('aktif', 1);
        return $query;
    }

    public function scopeNonaktif($query)
    {
        $query->whereNull('aktif')->orWhere('aktif', 0);
        return $query;
    }

    public function getLevelAttribute()
    {
        $gaji = $this->gaji()->where('member_id', $this->id)->latest('id')->first();
        if ($gaji) {
            return $gaji->level ? $gaji->level->nama : 'belum';
        } else {
            return 'belum';
        }
    }

    public function getRfidAttribute()
    {
        $belum = "<a href='" . url('bisnis/sdm/member/' . $this->id . '/absen/create') . "' class='popup-tafio'>belum</a>";
        $sudah = "<a href='" . url('bisnis/sdm/member/' . $this->id . '/absen/create') . "' class='popup-tafio'>sudah</a>";
        return $this->attributes['rfid'] ? $sudah : $belum;
    }

    public function getLahirAttribute()
    {
        return $this->attributes['tempatLahir'] . ' ' . $this->attributes['tglLahir'];
    }

    public function getCountTunjanganAttribute()
    {
        $tunjangan = $this->tunjangan()->where('member_id', $this->id)->whereYear('created_at', '=', Carbon::now()->year)
            ->orderBy('id', 'DESC')->first();
        isset($tunjangan->saldo) ? $saldo = $tunjangan->saldo : $saldo = 0;
        return $saldo;
    }

    public function getCountCutiAttribute()
    {
        $tahun = date('Y');
        $cuti = $this->cuti()
            ->where("tanggal", '>=', $tahun . "-01-01")
            ->where("tanggal", '<=', $tahun . "-12-31")
            ->where("cuti", 1)
            ->get()->count();
        return $cuti;
    }

    public function getCountIjinAttribute()
    {
        $tahun = date('Y');
        $ijin = $this->cuti()
            ->where("tanggal", '>=', $tahun . "-01-01")
            ->where("tanggal", '<=', $tahun . "-12-31")
            ->where("cuti", 0)
            ->get()->count();
        return $ijin;
    }

    public function getLamaKerjaAttribute()
    {
        $hitung = hitungTahun($this->tglMasuk);
        return $hitung['tahun'] . ' tahun ' . $hitung['bulan'] . ' bulan';
    }

    public function getCountLemburAttribute()
    {
        $tahun = date('Y');
        $lembur = $this->lembur()
            ->where("tahun", '=', $tahun)
            ->sum('jam');
        return $lembur;
    }

    public function scopeSemua($query, $var)
    {
        $query->select('namaLengkap', 'id');
        $query->where('aktif', 1);
        $query->where('namaLengkap', 'LIKE', '%' . $var['q'] . '%');
        return $query;
    }

    public function getUmurAttribute()
    {
        return hitungTahun($this->tglLahir)['tahun'] . " tahun";
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->company_id = session('company');
        });

    }

}
