<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;

class akunKategori extends Model
{
    use sortable;
    protected $guarded = [];

    public function akunDetail()
    {
        return $this->hasMany(akunDetail::class);
    }

    public function akun()
    {
        return $this->belongsTo(akun::class);
    }

}
