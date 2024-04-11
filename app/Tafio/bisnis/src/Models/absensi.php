<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class absensi extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "data_absensis";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function scopeJenis($query, $data)
    {
        $tahun = $data[0];
        $bulan = $data[1];
        $query->where(function (Builder $queryx) use ($tahun,$bulan) {
            if ($tahun) {
                $queryx->whereYear('created_at', $tahun);
            }
            if ($bulan) {
                $queryx ->whereMonth('created_at', $bulan);
            }
        });

        return $query;
    }
     
    public function member()
    {
        return $this->belongsTo(member::class);
    }
}
