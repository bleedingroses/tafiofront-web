<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class akunDetail extends Model
{
    use sortable;
    protected $guarded = [];

    public function getSaldoAttribute()
    {
        return (float) $this->attributes['saldo'];
    }

    public function scopetotalProduk($query)
    {
        $where = '';
        $dari = request()->dari ?? date("Y-m");
        $sampai = request()->sampai ?? date("Y-m");
        $xx = explode('-', $dari);
        $yy = explode('-', $sampai);

        $where .= "year(projects.created_at)>=" . $xx[0] . " and
            month(projects.created_at)>=" . $xx[1] . " and
            year(projects.created_at)<=" . $yy[0] . " and
            month(projects.created_at)<=" . $yy[1] . " and ";

        $query->select('akun_details.nama', 'akun_details.no_akun', 'akun_details.id', 'akun_details.akun_kategori_id', 'akun_details.kategori_utama_id', 'total')
            ->leftJoin(DB::raw(
                "(
                select projects.created_at,produk_models.akun_detail_id, SUM(`project_details`.`harga`*`project_details`.`jumlah`) as total
                from `project_details`,`produk_models`, `projects` where
                `produk_models`.`id` = `project_details`.`produk_model_id` and
                " . $where . "
                `projects`.`id` = `project_details`.`project_id` group by `produk_models`.`akun_detail_id`) as A"),
                "A.akun_detail_id", "=", "akun_details.id")
            ->where('akun_kategori_id', 401);

        return $query;
    }

    public function scopeTotalbahan($query)
    {
        $where = '';
        $dari = request()->dari ?? date("Y-m");
        $sampai = request()->sampai ?? date("Y-m");
        $xx = explode('-', $dari);
        $yy = explode('-', $sampai);

        $where .= "year(keuangan_belanjas.created_at)>=" . $xx[0] . " and
            month(keuangan_belanjas.created_at)>=" . $xx[1] . " and
            year(keuangan_belanjas.created_at)<=" . $yy[0] . " and
            month(keuangan_belanjas.created_at)<=" . $yy[1] . " and ";

        return $query->select('akun_details.nama', 'akun_details.no_akun', 'akun_details.id', 'akun_details.akun_kategori_id', 'total')
            ->leftJoin(DB::raw("(select keuangan_belanjas.created_at, produk_models.akun_detail_id,SUM(keuangan_belanja_details.harga*keuangan_belanja_details.jumlah)
        as total from `keuangan_belanja_details`,`produk_models`,keuangan_belanjas where `produk_models`.`id` = `keuangan_belanja_details`.`produk_model_id`
        and " . $where . " keuangan_belanjas.id = keuangan_belanja_details.belanja_id group by produk_models.akun_detail_id
        ) as A"), "A.akun_detail_id", "=", "akun_details.id")
            ->Where(function ($query) {
                $query->where('akun_details.akun_kategori_id', 501)
                    ->orWhere('akun_details.akun_kategori_id', 502)
                    ->orWhere('akun_details.akun_kategori_id', 103);
            });
    }

    public function scopeSemuaKas($query)
    {
        return $query->whereIn('akun_kategori_id', [101, 102, 103]);
    }
    public function scopeKasMarketplace($query)
    {
        return $query->where('akun_kategori_id', 103);
    }
    public function scopeKas($query, $akundetil = null)
    {
        if ($akundetil) {
            $query->where('id', '<>', $akundetil);
        }
        return $query->whereIn('akun_kategori_id', [101, 102]);
    }

    public function transfer()
    {
        return;
    }

    public function masuk()
    {
        return;
    }

    public function bukuBesar()
    {
        return $this->hasMany(bukuBesar::class);
    }

    public function produk()
    {
        return $this->hasMany(produkModel::class);
    }

    public function barangBeli()
    {
        return $this->hasMany(barangBeli::class);
    }
    public function keuangan()
    {
        return $this->hasMany(kontakKeuangan::class);
    }

    public function kategoriUtama()
    {
        return $this->belongsTo(kategoriUtama::class);
    }

    public function akunKategori()
    {
        return $this->belongsTo(akunKategori::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->company_id = session('company');
        });

    }
}
