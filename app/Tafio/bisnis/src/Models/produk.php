<?php

namespace App\Tafio\bisnis\src\Models;

use carbon\carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class produk extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "produks";

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }


public function stokTotal($cabang=null)
{

$hasil=$this->produkStok()->lastStok();

if($cabang)
return $hasil->where('cabang_id',$cabang)->first()->saldo??0;
else
return $hasil->sum('saldo')??0;

}



    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->company_id = session('company');
        });
    }

    public function scopeApi_beli($query, $var)
    {
        $query->where('beli', 1);
        return $this->search($query, $var);

    }

    public function getStokMinAttribute()
    {
        return floor($this->penjualanHarian * ($this->waktu_po) * 1.5);
    }
    public function lastStok($toko)
    {
    return ($this->produkStok()->
    where('cabang_id', $toko)->latest('id')->first()->saldo) ?? 0;
    }
    public function getPenjualanHarianAttribute()
    {

        $awal = carbon::now()->subMonths(3)->startOfMonth();
        $akhir = carbon::now()->endOfMonth();

        $jumlah = $this->omzet()->whereBetween('tanggal', [$awal, $akhir])->sum('jumlah');

        $total_hari = $awal->diffInDays(carbon::now());

        return round($jumlah / $total_hari, 2);

    }

    public function scopeAnalisaStok($query)
    {

        return $query->where('produks.company_id', session('company'))
            ->join('produk_models', 'produk_models.id', '=', 'produks.produk_model_id')
            ->leftjoin('data_kontaks', 'produk_models.supplier_id', '=', 'data_kontaks.id')
            ->join('produk_kategoris', 'produk_models.kategori_id', '=', 'produk_kategoris.id')
            ->join('produk_kategori_utamas', 'produk_kategori_utamas.id', '=', 'produk_kategoris.kategori_utama_id')
            ->where('produk_models.jual', 1)->where('produk_models.stok', 1)
            ->where('produk_models.beli', 1)
            ->where('status', 1);

    }
    public function scopeApi_stok($query, $var)
    {
        $query->where('stok', 1);
        return $this->search($query, $var);
    }

    public function scopeApi_jual($query, $var)
    {
        $query->where('jual', 1);
        return $this->search($query, $var);
    }

    public function search($query, $var)
    {

        $keys = explode(' ', $var['q']);

        $query->selectRaw("produks.id as id,
        if(length(produks.nama),concat(produk_kategoris.nama,' ', produk_models.nama,'-',produks.nama),
        concat(produk_kategoris.nama,' ', produk_models.nama)) as namaLengkap");
        $query->join('produk_models', 'produk_models.id', '=', 'produks.produk_model_id')
            ->join('produk_kategoris', 'produk_models.kategori_id', '=', 'produk_kategoris.id')
            ->where('status', 1)
            ->where('kategori_utama_id', '!=', null)
            ->where('produk_models.company_id', session('company'));

        foreach ($keys as $key) {
            $query->where(function ($query2) use ($key) {
                $query2->where('produk_models.nama', 'LIKE', '%' . $key . '%')->
                    orWhere('produks.nama', 'LIKE', '%' . $key . '%')->
                    orWhere('produk_kategoris.nama', 'LIKE', '%' . $key . '%');
            })->where('produk_models.company_id', session('company'));
        }

        return $query;
    }

    public function scopeApi_produksi($query, $var)
    {
        $query->where('produksi', 1);
        return $this->search($query, $var);

    }

    public function history()
    {
        return $this->hasMany(belanjaDetail::class);
    }

    public function produkStok()
    {
        return $this->hasMany(produkStok::class, 'produk_id');
    }

    public function getnamaLengkapAttribute()
    {
        $nama = '';
        // if ($this->produkModel->kategori) {
            //     $nama = $this->produkModel->kategori->nama . ' - ';
        // }
        $nama .= $this->produkModel->nama;
        if (!empty($this->nama)) {
            $nama .= '(' . $this->nama . ')';
        }
        return $nama;
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }


    public function produkModel()
    {
        return $this->belongsTo(produkModel::class);
    }

    public function omzet()
    {
        return $this->hasMany(omzet::class);
    }
    public function poDetail()
    {
        return $this->hasMany(poDetail::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function supplier()
    {
        return $this->belongsTo(kontak::class);
    }

    public function bahan()
    {
        return $this->belongsToMany(produk::class, 'produk_model_bahan', 'produk_id', 'produk_model_id')->withPivot('jumlah');
    }
}
