<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class piutang extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "k_piutangs";

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

    public function getBayarAttribute()
    {
        if ($this->total - $this->pembayaran == 0) {
            return '<button class="btn btn-rounded btn-info btn-sm">lunas</button>';
        } else {
            return link_biasa('bisnis/keuangan/piutang/' . $this->id . '/bayar/create', 'bayar', 'class="btn btn-rounded btn-success btn-sm ');
        }
    }

    public function scopeBelumLunas($query)
    {

        $query->whereRaw('pembayaran < total');
        return $query;
    }
    public function bayar()
    {
        return $this->belongsTo(piutang::class);
    }

    public function piutangDetail()
    {
        return $this->hasMany(piutangDetail::class);
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
