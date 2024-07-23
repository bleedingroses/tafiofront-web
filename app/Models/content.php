<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class content extends Model
{

protected $guarded = [];
protected $table='web_contents';


     public function content(){
      return $this->hasMany(content::class)
        ;
    }

public function menu(){ return $this->belongsTo((menu::class));}


}