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

}
