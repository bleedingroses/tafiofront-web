<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class projectMarketing extends Model
{
    use sortable;
    protected $guarded = [];

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

    public function getFollowupNextAttribute()
    {
        $tanggal = date_create($this->attributes['followup_next']);
        return date_format($tanggal, "d-m-Y");
    }

    public function scopeCalon($query)
    {
        return $query->whereNull('kontak_id');
    }

    public function scopeTerdaftar($query)
    {
        return $query->whereNotNull('kontak_id')
            ->where('status', '<>', 'batal')
            ->where('status', '<>', 'order')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function scopeBlmTerdaftar($query)
    {
        return $query->whereNull('kontak_id')
            ->where('status', '<>', 'batal')
            ->where('status', '<>', 'order')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function detail()
    {
        return $this->belongsTo(followupChat::class);
    }

    public function kontak()
    {
        return $this->belongsTo(kontak::class);
    }

    public function ar()
    {
        return $this->belongsTo(ar::class);
    }

    public function klien()
    {
        return $this->belongsTo(klien::class);
    }

    public function company()
    {
        return $this->belongsTo(company::class);
    }
}
