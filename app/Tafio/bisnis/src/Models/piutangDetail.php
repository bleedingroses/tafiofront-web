<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class piutangDetail extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table ="k_piutang_details";

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

    public function akunDetail()
    {
        return $this->belongsTo(akunDetail::class);
    }
    
    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
