<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class bagian extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "hrd_bagians";

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
