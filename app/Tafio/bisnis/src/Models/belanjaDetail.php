<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class belanjaDetail extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "keuangan_belanja_details";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function getTotalAttribute()
    {
        return $this->harga * $this->jumlah;
    }

    public function produk()
    {
        return $this->belongsTo(produk::class);
    }

    public function belanja()
    {
        return $this->belongsTo(belanja::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    protected static function boot()
    {
        parent::boot();

        self::saved(function ($model) {
            $model->produk->produkModel()->update(['supplier_id' => $model->belanja->kontak_id]);
        });

        self::creating(function ($model) {
            $model->company_id = session('company');
        });

    }
}
