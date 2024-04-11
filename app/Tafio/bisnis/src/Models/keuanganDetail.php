<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class keuanganDetail extends Model
{
    protected $fillable = ['ket', 'jumlah', 'akun_detail_id', 'company_id', 'keuangan_id'];
    protected $table = "keuangan_kontak_details";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    protected static function boot()
    {
        parent::boot();

        keuanganDetail::saved(function ($model) {

            $model->keuangan->update([]);

            $keuangan = $model->keuangan;
            if ($keuangan->jenis == 'hutang') {
                $ket = 'bayar hutang ke ' . $keuangan->kontak->namaLengkap;
                $kredit = $model->jumlah;
                $debet = 0;
                $kode = 'bht';
                $detail = $keuangan->id;
            } else if ($keuangan->jenis == 'order') {
                $ket = $keuangan->kontak->namaLengkap . " bayar order";
                $debet = $model->jumlah;
                $kredit = 0;
                $kode = 'ord';
                $detail = $keuangan->detail_id;
            } else if ($keuangan->jenis == 'belanja') {
                $debet = 0;
                $kredit = $model->jumlah;
                $ket = 'bayar belanja ke ' . $keuangan->kontak->namaLengkap;
                $kode = 'blj';
                $detail = $keuangan->detail_id;
            } else {
                $kredit = 0;
                $debet = $model->jumlah;
                $ket = 'pembayaran piutang dari ' . $keuangan->kontak->namaLengkap;
                $kode = 'bpt';
                $detail = $keuangan->id;

            }

            if ($model->akunDetail) {
                $model->akunDetail->bukuBesar()->create([
                    'ket' => $ket,
                    'kredit' => $kredit,
                    'debet' => $debet,
                    'detail_id' => $detail,
                    'kode' => $kode,
                ]);
            }
        });

        self::creating(function ($model) {
            $model->company_id = session('company');
            $model->user_id = auth()->user()->id;
        });
    }
    
    public function keuangan()
    {
        return $this->belongsTo(kontakKeuangan::class);
    }

    public function akunDetail()
    {
        return $this->belongsTo(akunDetail::class);
    }

    public function getUserAttribute()
    {
        $user = User::find($this->attributes['user_id']);
        return substr($user ? $user->email : null, 0, 5);
    }
}
