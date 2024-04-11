<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class produkStok extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produk_stoks";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function getTotalAttribute()
    {
        if ($this->attributes['kode'] == 'bahanProduksi') {
            return $this->attributes['kurang'] * $this->produk()->first()->produkModel->harga;
        }
    }

    public function scopePercabang($query, $cabang)
    {
        return $query->where('cabang_id', $cabang);
    }

    public function scopeOpname($query)
    {
        return $query->where('kode', 'opname');
    }

    public function scopePakai($query)
    {
        return $query->where('kode', 'pakai');
    }

    public function scopeBahan($query)
    {
        return $query->where('kode', 'bahanProduksi');
    }

    public function scopePerproduk($query, $produk)
    {
        return $query->where('produk_id', $produk);
    }
    public function produksi()
    {
        return $this->belongsTo(produksi::class, 'detail_id');
    }
    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }
    public function produk()
    {
        return $this->belongsTo(produk::class);
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


public function scopeLastStok($query)
{
return $query->select('produk_id','saldo','cabang_id','kategori_id','produks.hpp')
->join('produks','produks.id','=','produk_stoks.produk_id')
->join('produk_models','produk_models.id','=','produks.produk_model_id')
->where('produk_stoks.company_id',session('company'))
->where('status',1)
->whereRaw('produk_stoks.id IN (SELECT MAX(id) 
             FROM produk_stoks 
             GROUP BY company_id,produk_id,cabang_id)');
}

    protected static function boot()
    {
        parent::boot();

        produkStok::saving(function ($model) {

            if (!empty($model->id)) 
                $terakhir = ($model->where('produk_id', $model->produk_id)->
                        where('id', '<', $model->id)->
                        where('cabang_id', $model->cabang_id)->latest('id')->first()->saldo) ?? 0;
             else 
                $terakhir = ($model->where('produk_id', $model->produk_id)->
                        where('cabang_id', $model->cabang_id)->latest('id')->first()->saldo) ?? 0;
            

            $model->saldo = $terakhir + $model->tambah - $model->kurang;
            $model->hpp = $model->produk->hpp;

        });

        produkStok::deleted(function ($model) {

            $sesudah = produkStok::where('id', '>', $model->id)->where('produk_id', $model->produk_id)
                ->where('cabang_id', $model->cabang->id)->orderBy('id', 'asc')->get();

            foreach ($sesudah as $hasil) {
                $hasil->save();
            }
         
        });

        self::creating(function ($model) {
            $model->company_id = session('company');
            $model->user_id = auth()->user()->id;
        });

        // produkStok::saved(function ($model) {

        //     if ($model->kode == "bahanProduksi") {
        //         //add harga beli di produk
        //         $produk = $model->produk;
        //         $hpp = $produk->hpp ? $produk->hpp : $produk->produkModel->harga;
        //         $model->harga = $hpp;
        //         //update biaya produksi
        //         $produksi = produksi::find($model->detail_id);
        //         $total = $hpp * $model->kurang;

        //         $produksi->update(['biaya' => $total + $produksi->biaya]);
        //     }

        //     if ($model->kode == "hasilProduksi") {
        //         $produksi = produksi::find($model->detail_id);
        //         $total = $produksi->hasil + $model->tambah;
        //         $produksi->update(['hasil' => $total]);
        //     }
        // });
    }

}
