<?php

namespace App\Tafio\bisnis\src\Models;

use DB;
use Tafio\core\src\Models\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class produksi extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_produksis";

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
            $model->user_id = auth()->user()->id;
        });
    }

    public function belanja()
    {
        return $this->belongsToMany(belanja::class, 'produk_produksi_belanja', 'produksi_id', 'belanja_id');
    }

    public function getHppAttribute()
    {
        if ($this->biaya && $this->hasil) {
            return $this->biaya / $this->hasil;
        }
    }

    public function scopeFinish($query)
    {
        return $query->where('status', 'finish');
    }

    public function scopeProses($query)
    {
        return $query->where('status', 'proses');
    }

    public function produk()
    {
        return $this->belongsTo(produk::class);
    }
    public function bahan()
    {
        return $this->hasMany(produkStok::class, 'detail_id')->where('kode', 'bahanProduksi');
    }
    public function hitungBiaya()
    {
        // dd($this->id);
        $biaya = $this->belanja()->sum('total');
        $stok = $this->bahan()->sum(DB::raw('kurang * hpp'));

        $this->update(['biaya' => $biaya + $stok]);
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function getUserAttribute()
    {
        $user = User::find($this->attributes['user_id']);
        return substr($user ? $user->email : null, 0, 5);
    }
}
