<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class gaji extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "hrd_gajis";

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

    public function getJumlahLainAttribute()
    {
        return (float) $this->attributes['jumlah_lain'];
    }

    public function level()
    {
        return $this->belongsTo(level::class);
    }

    public function member()
    {
        return $this->belongsTo(member::class);
    }
    public function bagian()
    {
        return $this->belongsTo(bagian::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
