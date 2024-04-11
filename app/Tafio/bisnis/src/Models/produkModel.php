<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class produkModel extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_models";

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

    public function getHargaBeliAttribute()
    {
        if (array_key_exists("produkId", $this->attributes)) {
            if ($this->beli === 1) {
                $belanja = belanjaDetail::where('produk_id', $this->id)->latest('id')->first();
                $data = $belanja ? number_format($belanja->harga, 2, ",", ".") : 0;
                return $data;
            } else {
                return '';
            }

        }
    }



    // public function scopeOmzetBeli($query)
    // {
    //     $where = '';
    //     $dari = request()->dari ?? date("Y-m");
    //     $sampai = request()->sampai ?? date("Y-m");
    //     $xx = explode('-', $dari);
    //     $yy = explode('-', $sampai);

    //     $where .= "year(keuangan_belanjas.created_at)>=" . $xx[0] . " and
    //         month(keuangan_belanjas.created_at)>=" . $xx[1] . " and
    //         year(keuangan_belanjas.created_at)<=" . $yy[0] . " and
    //         month(keuangan_belanjas.created_at)<=" . $yy[1] . " and ";

    //     $query->select('*', 'totalBeli')
    //         ->leftJoin(DB::raw("(
    //         select keuangan_belanjas.created_at, keuangan_belanja_details.produk_model_id,SUM(keuangan_belanja_details.harga*keuangan_belanja_details.jumlah) as totalBeli
    //         from `keuangan_belanja_details`,keuangan_belanjas
    //         where " . $where . "
    //          keuangan_belanjas.id = keuangan_belanja_details.belanja_id
    //          group by keuangan_belanja_details.produk_model_id
    //         ) as A"), "A.produk_model_id", "=", "produk_models.id");
    //     return $query;
    // }

    // public function scopeOmzetJual($query)
    // {
    //     $where = '';
    //     $dari = request()->dari ?? date("Y-m");
    //     $sampai = request()->sampai ?? date("Y-m");
    //     $xx = explode('-', $dari);
    //     $yy = explode('-', $sampai);

    //     $where .= "year(projects.created_at)>=" . $xx[0] . " and
    //         month(projects.created_at)>=" . $xx[1] . " and
    //         year(projects.created_at)<=" . $yy[0] . " and
    //         month(projects.created_at)<=" . $yy[1] . " and ";

    //     $query->select('*', 'totalJual')
    //         ->leftJoin(DB::raw("(
    //           select projects.created_at, project_details.produk_model_id,SUM(project_details.harga*project_details.jumlah) as totalJual
    //           from project_details,projects
    //           where " . $where . "
    //            projects.id = project_details.project_id
    //            group by project_details.produk_model_id
    //           ) as B"), "B.produk_model_id", "=", "produk_models.id");
    //     return $query;
    // }

    // public function scopeStok($query, $cabang)
    // {
    //     if ($cabang[0]->count() > 1) {
    //         foreach ($cabang[0] as $value) {
    //             $query->leftJoin(DB::raw(
    //                 "(select produk_model_id, saldo as " . $value->nama . "
    //                     from `produks`,`produk_laststoks` where produks.id = produk_laststoks.produk_id and produk_laststoks.cabang_id =  " . $value->id . ") as " . $value->nama . ""),
    //                 "" . $value->nama . ".produk_model_id", "=", "produk_models.id");
    //         }
    //     } else {
    //         $query->leftJoin(DB::raw(
    //             "(select produk_model_id, saldo as " . $cabang[0]->first()->nama . "
    //                 from `produks`,`produk_laststoks` where produks.id = produk_laststoks.produk_id and produk_laststoks.cabang_id =  " . $cabang[0]->first()->id . ") as B"),
    //             "B.produk_model_id", "=", "produk_models.id");
    //     }

    //     return $query;
    // }

    public function produk()
    {
        return $this->hasMany(produk::class);
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function supplier()
    {
        return $this->belongsTo(kontak::class, 'supplier_id');
    }

    public function bahan()
    {
        return $this->belongsToMany(produk::class, 'produk_model_bahan', 'produk_model_id', 'produk_id')->withPivot('jumlah');
    }
}
