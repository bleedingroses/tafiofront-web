<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class kategoriUtama extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_kategori_utamas";

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

    public function kategori()
    {
        return $this->hasMany(kategori::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

}
