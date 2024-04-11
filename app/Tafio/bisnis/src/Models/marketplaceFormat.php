<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class marketplaceFormat extends Model
{
    protected $guarded = [];
public static function shopee()
    {
return self::where('marketplace','shopee')->where('jenis', 'order')->first();
    }

}