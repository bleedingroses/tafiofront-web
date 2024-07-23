<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class company extends Model {
    protected $table = 'core_companies';

    protected $fillable = ['name', 'aktif'];

    public function menu() {
        return $this->hasMany(menu::class);
    }
    public function config() {
        return $this->hasMany(config::class);
    }

    public function ambilMenu($menu) {
        return $this->menu()->where('nama', $menu)->first();
    }
    public function ambilContent($menu) {
    $hasil=$this->menu()->where('nama', $menu)->first();
    
    if($hasil)
    return $hasil->content;
    else
    return [];
    }
    public function ambilKategori($menu) {
    $hasil=$this->menu()->where('nama', $menu)->first();
    
    if($hasil)
    return $hasil->kategori()->get();
    else
    return [];
    }


}
