<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class hutang extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "k_hutangs";

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

    public function getKekuranganAttribute()
    {
        return $this->total - $this->pembayaran;
    }
    public function scopeBelumLunas($query)
    {

        $query->whereRaw('pembayaran < total');
        return $query;
    }
    public function getBayarAttribute()
    {
        if ($this->total - $this->pembayaran == 0) {
            return '<button class="btn btn-rounded btn-info btn-sm">lunas</button>';
        } else {
            return link_biasa('bisnis/keuangan/hutang/' . $this->id . '/bayar/create', 'bayar', 'class="btn btn-rounded btn-success btn-sm ');
        }
    }

    public function bayar()
    {
        return $this->belongsTo(hutang::class);
    }

    public function hutangDetail()
    {
        return $this->hasMany(hutangDetail::class);
    }

    public function akun_detail()
    {
        return $this->belongsTo(akunDetail::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
