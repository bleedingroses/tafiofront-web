<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class cabang extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "project_cabangs";

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

    function produkStok(){
        return $this->hasMany(produkStok::class);
    }

  

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
