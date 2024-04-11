<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class sop extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "data_sops";
    
    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->company_id = session('company');
        });
    }

    public function scopePeraturan($query)
    {
        return $query
        ->where('bagian', '=', 'peraturan')
        ->orderBy('id', 'asc');
    }

    public function scopeJenis($query, $data)
    {
        return $query
        ->where('bagian', '=', $data[0])
        ->orderBy('id', 'asc');
    }
}
