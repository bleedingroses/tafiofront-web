<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class menu extends Model
{

protected $guarded = [];
protected $table='web_menus';

     public function content(){
      return $this->hasMany(content::class)
        ;
    }


     public function kategori(){
      return $this->hasMany(kategori::class)
        ;
    }




}


