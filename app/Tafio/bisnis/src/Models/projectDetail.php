<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class projectDetail extends Model
{
    use sortable;
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where($builder->qualifyColumn('company_id'), session('company'));
        });
    }

    public function scopeSearch($query)
    {
        if (!empty(request()->nama)) {
            $query->leftJoin(DB::raw(
                "(
                select projects.kontak_id, projects.id as idproject
                from `project_details`,`data_kontaks`, `projects` where
                `data_kontaks`.`id` = `projects`.`kontak_id` and
                `projects`.`id` = `project_details`.`project_id`) as A"),
                "A.idproject", "=", "project_details.project_id");
            $query->where('A.kontak_id', request()->nama);
        }
        return $query;
    }

    public function getTotalAttribute()
    {
        $harga = $this->attributes['harga'];
        $jumlah = $this->attributes['jumlah'];

        $total = $harga * $jumlah;
        return $total;
    }

    public function scopeDetail($query)
    {
        return $query->where('id', $this->id);
    }

    public function scopeCabang($query, $cabang)
    {
        $query->select('*', 'project_details.id as id');
        $query->join('projects', 'projects.id', '=', 'project_details.project_id');
        if ($cabang != 0) {
            $query->where('cabang_id', $cabang);
        }

        return $query;
    }

    public function getListprodukAttribute()
    {
        $yy = array();

        foreach ($this->spek as $item) {
            $yy[] = $item->nama . ' : ' . $item->pivot->keterangan;
        }
        return implode(', ', $yy);
    }

    public function process()
    {
        return $this->belongsTo(process::class);
    }

    public function project()
    {
        return $this->belongsTo(project::class);
    }

    public function flow()
    {
        return $this->belongsToMany(projectFlow::class, 'project_schedules', 'project_detail_id', 'project_flow_id')->withPivot('deadline');
    }

    public function spek()
    {
        return $this->belongsToMany(spek::class, 'project_speks', 'project_detail_id', 'spek_id')->withPivot('keterangan');
    }

    public function projectFlow()
    {
        return $this->belongsTo(projectFlow::class);
    }

    public function produk()
    {
        return $this->belongsTo(produk::class);
    }
    public function komplain()
    {
        return $this->hasOne(projectKomplain::class);
    }
    public function company()
    {
        return $this->belongsTo(company::class);
    }

    protected static function boot()
    {
        parent::boot();

        ProjectDetail::saved(function ($model) {

            $project = $model->project;

            if ($model->isDirty('project_flow_id') and $model->produk->produkModel->stok == 1) {


                if ($model->getOriginal('project_flow_id')) {
                    $awal = projectFlow::find($model->getOriginal('project_flow_id'))->grup->stok;
                } else {
                    $awal = 0;
                }

                $perubahan = projectFlow::find($model->project_flow_id)->grup->stok;

                if ($awal == 0 and $perubahan == 1) {



                    $model->produk->produkStok()->create([
                        'kurang' => $model->jumlah,
                        'keterangan' => 'dibeli ' . $project->kontak->namaLengkap,
                        'kode' => 'jual',
                        'cabang_id' => $project->cabang_id,
                        'project_id' => $model->id,
                    ]);
                } else if ($awal == 1 and $perubahan == 0) {$stok = $model->produk->produkStok()->where('project_id', $model->id)->first();
                    if ($stok) {
                        $stok->delete();
                    }

                }
            }
            $project->update([]);

            $ambil = projectDetail::where('produk_id', $model->produk_id)
                ->where('omzet', 1)
                ->whereMonth('projects.created_at', $project->created_at->month)
                ->whereYear('projects.created_at', $project->created_at->year)
                ->where('cabang_id', $project->cabang_id)
                ->join('projects', 'projects.id', '=', 'project_details.project_id')
                ->join('project_flows', 'project_flows.id', '=', 'project_details.project_flow_id')
                ->join('project_grups', 'project_grups.id', '=', 'project_flows.grup_id')
                ->selectRaw('sum(harga * jumlah) as total_penjualan, sum(jumlah) as total_jumlah')->first();
            ;

            $tgl = $project->created_at->year . '-' . $project->created_at->month . '-15';
            $model->produk->omzet()->updateOrCreate(['cabang_id' => $model->project->cabang_id, 'tanggal' => $tgl],
                ['omzet' => $ambil->total_penjualan, 'jumlah' => $ambil->total_jumlah]);

        });

        self::creating(function ($model) {
            $model->company_id = session('company');
        });

    }
}
