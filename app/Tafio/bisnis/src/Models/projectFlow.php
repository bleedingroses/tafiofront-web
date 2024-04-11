<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class projectFlow extends Model
{
    use sortable;
    protected $guarded = [];

    public function project_detail()
    {
        return $this->hasMany(projectDetail::class);
    }

    public function projectDetail()
    {
        return $this->belongsToMany(projectDetail::class, 'project_schedules', 'project_flow_id', 'project_detail_id')->withPivot('deadline');
    }
    public function grup()
    {
        return $this->belongsTo(grup::class);
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
