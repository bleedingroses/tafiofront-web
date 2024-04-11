<?php

namespace App\Tafio\bisnis\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class marketplaceConfig extends Model
{
    protected $guarded = [];
    public $timestamps = false;

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
    
    public function company()
    {
        return $this->belongsTo(company::class);
    }
    public function cabang()
    {
        return $this->belongsTo(cabang::class);
    }
    public function kontak()
    {
        return $this->belongsTo(kontak::class);
    }
    public function kas()
    {
        return $this->belongsTo(akundetail::class, 'kas_id');
    }
    public function penarikan()
    {
        return $this->belongsTo(akundetail::class, 'penarikan_id');
    }

    public function getSinkronAttribute()
{

  if($this->marketplace=='shopee')
  { 
if($this->autosinkron)
    return $this->autosinkron."<br>putuskan";
    else
    {

$format = marketplaceFormat::where('marketplace','shopee')->where('jenis', 'order')->first();

        $path = "/api/v2/shop/auth_partner";
        $redirectUrl=route('shopeeconnect',['marketplace'=>$this->id]);
        $timest = time();
        $baseString = sprintf("%s%s%s", $format->partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $format->partnerKey);

        $shopeeConnectUrl = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $format->host, $path, $format->partnerId, $timest, $sign, $redirectUrl);
    return "<a href=".$shopeeConnectUrl.">sinkronkan</a>";
    }
}
else
return 'blm bisa';
}


}
