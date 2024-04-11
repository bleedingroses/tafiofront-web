<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class bukuBesar extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "akun_buku_besars";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function getKreditAttribute()
    {
        return (float) ($this->attributes['kredit'] ?? 0);
    }

    public function getKetLinkAttribute()
    {
        if (in_array($this->kode, ['htg', 'ptg', 'bht', 'bpt'])) {
            return
            "<a class=' popup-tafio' href='" . url('bisnis/data/keuangan/' . $this->detail_id . '/keuanganDetail') . "'>" .
            $this->ket;
        } else if ($this->kode == 'ord') {
            return "<a class=' popup-tafio' href='" . url('bisnis/jasa/project/' . $this->detail_id) . "'>" .
            $this->ket;
        } else if ($this->kode == 'blj') {
            return "<a class=' popup-tafio' href='" . url('bisnis/keuangan/belanja/' . $this->detail_id) . "/belanjaDetail'>" .
            $this->ket;
        } else {
            return $this->ket;
        }

    }

    public function akunDetail()
    {
        return $this->belongsTo(akunDetail::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function jurnal()
    {
        return $this->belongsTo(jurnal::class);
    }

    public function getUserAttribute()
    {
        $user = User::find($this->attributes['user_id']);
        return substr($user ? $user->email : null, 0, 5);
    }

    protected static function boot()
    {
        parent::boot();

        bukuBesar::saving(function ($model) {
            if ($model->akunDetail->akun_kategori_id != 103) {
        //////kecuali marketplace, ga usah diitung saldonya
                $terakhir = $model->where('akun_detail_id', $model->akun_detail_id)->latest('id')->first();
                $saldoAwal = $terakhir->saldo ?? 0;
                $model->saldo = $saldoAwal + $model->debet - $model->kredit;
                $model->akunDetail()->update(['saldo' => $model->saldo]);
            }
        });

        self::creating(function ($model) {
            $model->company_id = session('company');
            $model->user_id = auth()->user()->id;
        });
        
    }

}
