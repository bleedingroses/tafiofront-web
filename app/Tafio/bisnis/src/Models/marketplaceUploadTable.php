<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Model;

class marketplaceUploadTable extends Model
{
    protected $guarded = [];

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
