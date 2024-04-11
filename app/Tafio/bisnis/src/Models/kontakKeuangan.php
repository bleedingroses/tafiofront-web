<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class kontakKeuangan extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "keuangan_kontaks";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function kontak()
    {
        return $this->belongsTo(kontak::class);
    }

    public function keuanganDetail()
    {
        return $this->hasMany(keuanganDetail::class,'keuangan_id');
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('kekurangan', '>', 0);
    }

    public function akunDetail()
    {
        return $this->belongsTo(akunDetail::class);
    }

    public function project()
    {
        return $this->belongsTo(project::class, 'detail_id');
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

    protected static function boot()
    {
        parent::boot();

        kontakKeuangan::saving(function ($model) {
            
            $terbayar = $model->keuanganDetail()->sum('jumlah');
            $model->kekurangan = $model->total - $terbayar;
        });

        kontakKeuangan::saved(function ($model) {

            $kontak = $model->kontak;

            $piutang = $kontak->keuangan()->whereIn('jenis', ['piutang', 'order','deposit'])->sum('kekurangan');
            $hutang = $kontak->keuangan()->whereIn('jenis', ['hutang', 'belanja'])->sum('kekurangan');
            $saldo = $piutang - $hutang;

            $model->kontak()->update(['saldo' => $saldo]);

        });

        self::creating(function ($model) {
            $model->company_id = session('company');
            $model->user_id = auth()->user()->id;
        });
    }
}
