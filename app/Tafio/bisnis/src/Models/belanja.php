<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class belanja extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "keuangan_belanjas";

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

    public function produksi()
    {
        return $this->belongsToMany(produksi::class, 'produk_produksi_belanja', 'belanja_id', 'produksi_id');
    }

    public function po()
    {
        return $this->belongsToMany(po::class, 'produk_po_belanja', 'belanja_id', 'po_id');
    }

    public function scopeSearch($query)
    {
        if (!empty(request()->namaLengkap)) {
            $query->leftJoin(DB::raw(
                "(select belanja_id,produk_id
                from `keuangan_belanja_details`)as A"),
                "A.belanja_id", "=", "keuangan_belanjas.id");
            $query->where('A.produk_id', request()->namaLengkap);
        }
        return $query;
    }

    public function keuangan()
    {
        return $this->hasOne(kontakKeuangan::class, 'detail_id')
            ->where('jenis', 'belanja');

    }

    public function scopeHistory($query, $id)
    {
        $query->distinct();
        $query->join('keuangan_belanja_details', 'keuangan_belanjas.id', '=', 'keuangan_belanja_details.belanja_id');
        $query->where('keuangan_belanja_details.produk_id', $id);
        $query->select('keuangan_belanjas.created_at', 'produk_id', 'kontak_id', 'keuangan_belanja_details.harga', 'keuangan_belanja_details.jumlah', 'keuangan_belanja_details.keterangan', );
        return $query;
    }

    public function scopeBelumLunas($query)
    {
        return $query->whereRaw('total > pembayaran + diskon');
    }

    public function getProdukAttribute()
    {
        $yy = array();

        foreach ($this->belanjaDetail as $item) {
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

    public function getTanggalBeliAttribute()
    {
        if (array_key_exists("tanggal_beli", $this->attributes)) {
            $date = date_create($this->attributes['tanggal_beli']);
            return date_format($date, "d-m-Y");
        }
    }

    public function belanjaBayar()
    {
        return $this->hasMany(belanjaBayar::class);
    }

    public function belanjaDetail()
    {
        return $this->hasMany(belanjaDetail::class);
    }

    public function akunDetail()
    {
        return $this->belongsTo(akunDetail::class);
    }

    public function kontak()
    {
        return $this->belongsTo(kontak::class);
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class);
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
