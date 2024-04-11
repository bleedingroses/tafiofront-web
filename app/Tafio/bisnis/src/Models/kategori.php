<?php

namespace App\Tafio\bisnis\src\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class kategori extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_kategoris";

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

    public function kategoriUtama()
    {
        return $this->belongsTo(kategoriUtama::class);
    }

    public function produkModel()
    {
        return $this->hasMany(produkModel::class);
    }

    public function produkNonAktif()
    {
        return $this->hasMany(produkModel::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function getOmzetAttribute()
    {

        return omzet::whereRaw('produk_kategoris.id=' . $this->id)
            ->join('produks', 'produks.id', '=', 'produk_omzets.produk_id')
            ->join('produk_models', 'produks.produk_model_id', '=', 'produk_models.id')
            ->join('produk_kategoris', 'produk_kategoris.id', '=', 'produk_models.kategori_id')->
            sum('omzet');

    }

}
