<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class ar extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "hrd_ars";

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

    public function scopePercabang($query, $id)
    {
        return $query->where('cabang_id', $id);
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }

    public function member()
    {
        return $this->belongsTo(member::class);
    }

    public function konsumen()
    {
        return $this->hasMany(konsumen::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function getNamaAttribute()
    {
        return $this->member->kontak->namaLengkap;
    }

}
