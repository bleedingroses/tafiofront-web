<?php

namespace App\Tafio\bisnis\src\Models;

use Tafio\core\src\Models\User;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class project extends Model
{
    use sortable;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function scopePercabang($query, $id)
    {
        return $query->where('cabang_id', $id);
    }

    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }

    public function getTemaAttribute()
    {
        $yy = array();

        foreach ($this->projectDetail as $item) {
            $yy[] = $item->tema;
        }
        return implode(', ', $yy);
    }

    public function getListprodukAttribute()
    {
        $yy = array();
        foreach ($this->projectDetail as $item) {
            $yy[$item->produk_id] = $item->produk->namaLengkap??'';
        }
        return implode(', ', $yy);
    }

    public function getBulanTahunAttribute()
    {
        return $this->monthname . ' ' . $this->year;
    }

    public function scopeBelumlunas($query, $var)
    {
        $query->whereRaw('total  > pembayaran');

        if (!request()->kontak_id) {
            if (!empty(request()->tahun)) {
                $query->whereYear('created_at', request()->tahun);
            } else {
                $query->whereYear('created_at', $var[0]);
            }
        }

        return $query;
    }
    public function scopeSearch($query)
    {
        if (!empty(request()->namaLengkap)) {
            $query->leftJoin(DB::raw(
                "(select project_id,produk_id
                from `project_details`)as A"),
                "A.project_id", "=", "projects.id");
            $query->where('A.produk_id', request()->namaLengkap);
        }
        return $query;
    }

    public function scopeOmzettahun($query)
    {
        $query->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total) as sum'));
        $query->whereRaw('total');
        $query->orderBy('created_at', 'asc');
        $query->groupBy('year');
        return $query;
    }

    public function scopeOmzetBulanan($query)
    {
        $query->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('EXTRACT(YEAR_MONTH FROM created_at) as month'),
            DB::raw('MONTHNAME(created_at) as monthname'),
            DB::raw('SUM(total) AS omzet')
        );
        $query->whereRaw('total');
        $query->groupBy('month');
        $query->orderBy('created_at');
        return $query;
    }

    public function scopeYear($query)
    {
        $query->select(
            DB::raw('created_at,id, YEAR(created_at) as year'),
            DB::raw('DATE_FORMAT("created_at", "%H:%i:%s") as date'),
            DB::raw('SUM(total) as sum')
        );
        $query->groupBy('year');
        $query->orderBy('id', 'asc');
        return $query;
    }

    public function scopeKurang($query)
    {
        $query->leftJoin(DB::raw(
            "(select detail_id, kekurangan
                from `keuangan_kontaks`)as A"),
            "A.detail_id", "=", "projects.id");
        $query->where('A.kekurangan', "<", 0);
        return $query;
    }

    public function projectSpek()
    {
        return $this->hasMany(projectSpek::class);
    }
    public function keuangan()
    {
        return $this->hasOne(kontakKeuangan::class, 'detail_id')->where('jenis', 'order');
    }
    public function projectKomplain()
    {
        return $this->hasMany(projectKomplain::class);
    }

    public function projectDetail()
    {
        return $this->hasMany(projectDetail::class);
    }

    public function projectKurir()
    {
        return $this->hasMany(projectKurir::class);
    }

    public function klien()
    {
        return $this->belongsTo(klien::class);
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

    protected static function boot()
    {
        parent::boot();

        Project::saving(function ($model) {

            $total = 0;

            foreach ($model->projectDetail as $detail) {
                if ($detail->projectFlow->grup->omzet != 0) {
                    $total += $detail->jumlah * $detail->harga;
                }
            }
            $model->total = $total - $model->diskon + $model->ongkir;

        });

        Project::updated(function ($model) {

            if ($model->kontak->marketplace != 1) {
                $keuangan = ['total' => $model->total, 'ket' => 'order invoice: ' . $model->id];
                $model->keuangan()->updateOrCreate(['detail_id' => $model->id, 'jenis' => 'order', 'kontak_id' => $model->kontak_id], $keuangan);
            }
        });

        self::creating(function ($model) {
            $model->company_id = session('company');
            $model->user_id = auth()->user()->id;
        });
    }
}
