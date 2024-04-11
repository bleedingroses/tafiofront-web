<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Model;

class grup extends Model
{
    protected $guarded = [];
    protected $table = "project_grups";

    public static function ambilFlow($grup)
    {
        return self::where('nama', $grup)->first()->projectFlow()->orderBy('urutan')->first()->id;
    }

    public function projectFlow()
    {
        return $this->hasMany(projectFlow::class);
    }

    public static function ambil($nama)
    {
        return self::where('nama', $nama)->first();
    }

    public function getTotalOrderAttribute()
    {
        $total = 0;
        $kelurahan = $this->projectFlow()->withCount('project_detail')->get();
        foreach ($kelurahan as $xx) {
            $total += $xx->project_detail_count;
        }
        return $total;

    }

}
