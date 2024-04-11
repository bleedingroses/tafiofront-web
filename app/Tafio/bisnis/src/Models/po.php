<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class po extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_po";

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

    public function scopeProses($query)
    {
        return $query->where('status', 'proses');
    }

    public function scopeFinish($query)
    {
        return $query->where('status', 'finish');
    }

    public function getProdukAttribute()
    {
        $yy = array();

        foreach ($this->poDetail as $item) {
            if ($item->produk) {
                $yy[$item->produk_id] = $item->produk->namaLengkap;
            }
        }
        if (empty($yy)) {
            return 'belum diset';
        } else {
            return implode(', ', $yy);
        }
    }

    public function deposit()
    {
        return $this->belongsTo(kontakKeuangan::class);
    }

    public function belanja()
    {
        return $this->belongsToMany(belanja::class, 'produk_po_belanja', 'po_id', 'belanja_id');
    }

    public function poDetail()
    {
        return $this->hasMany(poDetail::class);
    }

    public function kontak()
    {
        return $this->belongsTo(kontak::class);
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
