<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class company extends Model
{
protected $table ='core_companies';

    protected $fillable = [ 'name','aktif'];

    public function module(){
      return $this->belongsToMany(module::class,'core_company_module')
        ->withPivot('disabled_core_page_ids')
        ->withTimestamps();
    } 
     public function submodule(){
      return $this->belongsToMany(submodule::class,'core_company_submodule')
        ;
    }
     public function menu(){
      return $this->hasMany(menu::class)
        ;
    }

	public function modulesetting(){
		return $this->belongsToMany(modulesetting::class,'core_company_settings')->withPivot('isi');
	}

}
