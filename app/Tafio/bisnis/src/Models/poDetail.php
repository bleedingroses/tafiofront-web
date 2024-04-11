<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class poDetail extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_po_detail";

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

    public function po()
    {
        return $this->belongsTo(po::class);
    }

    public function scopeProses($query)
    {
        return $query->
            join('produk_po', 'produk_po.id', '=', 'produk_po_detail.po_id')
            ->orderBy('tglKedatangan', 'asc')
            ->where('produk_po.status', 'proses');
    }

    public function produk()
    {
        return $this->belongsTo(produk::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
