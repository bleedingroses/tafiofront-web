<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class kontak extends Model
{
    use sortable;
    protected $guarded = [];
    protected $table = "data_kontaks";

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

    public function getNamaLengkapAttribute()
    {

        if (!empty($this->perusahaan)) {
            $nama = $this->perusahaan;
            if (!empty($this->nama)) {
                $nama .= " (" . $this->nama . ")";
            }

        } else {
            $nama = $this->nama;
        }

        return $nama;
    }

    public function getNamaRingkasAttribute()
    {
        if (!empty($this->perusahaan)) {
            return $this->perusahaan;
        } else {
            return $this->nama;
        }
    }

    public function scopePercabang($query, $id)
    {
        return $query->where('cabang_id', $id);
    }

    public function scopeApi_supplier($query, $var)
    {
        $query->where('supplier', 1);
        return $this->search($query, $var);
    }

    public function search($query, $var)
    {
        $keys = explode(' ', $var['q']);

        // $query->selectRaw("*,if(length(perusahaan),concat(perusahaan,'(',nama,')'),nama) as namaLengkap");
        $query->selectRaw("*,if(length(perusahaan),if(length(nama),concat(perusahaan,'(',nama,')'),perusahaan),nama) as namaLengkap");
        // $query->whereNotNull('cabang_id');

        foreach ($keys as $key) {
            $query->Where(function ($query) use ($key) {
                $query->where('nama', 'LIKE', '%' . $key . '%')
                    ->orWhere('perusahaan', 'LIKE', '%' . $key . '%');
            });
        }

        return $query;

    }

    public function scopeApi_konsumen($query, $var)
    {
        $query->where('konsumen', 1);
        return $this->search($query, $var);
    }

    public function scopeApi_marketplace($query, $var)
    {
        $query->where('marketplace', 1);
        return $this->search($query, $var);

    }
    public function getTotalOrderAttribute()
    {
        return $this->project()->get()->count();
    }

    public function getAllOmzetAttribute()
    {
        $total = array();
        $project = $this->project()->get();
        foreach ($project as $value) {
            $total[] = $value->total;
        }
        return array_sum($total);
    }

    public function getCountBelumLunasAttribute()
    {
        return $this->keuangan()->where('kekurangan', '>', '0')->count();
    }

    public function getMonthOmzetAttribute()
    {
        $total = array();
        $project = $this->project()->get();
        foreach ($project as $value) {
            $total[] = $value->total;
        }
        $allTotal = array_sum($total);

        if ($this->created_at) {
            $bulan = $this->created_at->diffInMonths();
        } else {
            $bulan = 1;
        }

        if ($bulan == 0) {
            $bulan = 1;
        }

        return floor($allTotal / $bulan);
    }

    public function getLastOrderAttribute()
    {
        return $this->keuangan()->latest('id')->first()->created_at ?? '';
    }

    public function scopeBelumLunas($query)
    {
        return $query->where('saldo', '>', 0);
    }

    public function scopeKonsumen($query)
    {
        $query->where('nama', 'LIKE', '%' . request()->kontak . '%');
        $query->orWhere('perusahaan', 'LIKE', '%' . request()->kontak . '%');
        return $query;
    }

    public function scopeJenis($query, $data)
    {
        $jenis = $data[0];
        $tahun = $data[1];
        $query->whereHas('keuangan', function (Builder $queryx) use ($jenis, $tahun) {
            $queryx->where('jenis', $jenis)
                ->whereRaw("kekurangan !=0");
            if ($tahun) {
                $queryx->whereYear('created_at', $tahun);
            }

        });

        return $query;
    }
    public function getMemberAttribute()
    {
        $member = member::where('kontak_id', $this->id)->first();
        return $member->id;
    }

    public function project()
    {
        return $this->hasMany(project::class);
    }

    public function ar()
    {
        return $this->belongsTo(ar::class);
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }

    public function supplier_kategori()
    {
        return $this->belongsTo(supplierKategoris::class);
    }

    public function keuangan()
    {
        return $this->hasMany(kontakKeuangan::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
