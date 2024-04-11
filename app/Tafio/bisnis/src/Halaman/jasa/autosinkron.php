<?php

namespace App\Tafio\bisnis\src\Halaman\jasa;

use Tafio\core\src\Library\Resource;
use App\Http\Controllers\ShopeeController;
use App\Http\Controllers\TokopediaController;
use Tafio\core\src\Models\User;
use App\Tafio\bisnis\src\Models\marketplaceFormat;
use Illuminate\Support\Facades\DB;
use Tafio\core\src\Library\Halaman\crud;

class autosinkron extends Resource {

    public function config(){
        $this->halaman = (new crud)->make();
//SEMENTARA supaya ga error projectlistnya kosong
        $user=User::all();
        $this->halaman->projectList=$user;
///////////////////////////////
        $toped = new TokopediaController;
        $this->halaman->buttonIndex = ['Connect to Tokopedia'=>route('tokopediaconnect')];
////Shopee
        $shopeeController = new ShopeeController;

        // untuk membuat link autentifikasi akun shopee
        //$host="https://partner.test-stable.shopeemobile.com/"; //pakai ini untuk development/test

$format = marketplaceFormat::where('marketplace','shopee')->where('jenis', 'order')->first();
$partnerId=$format->partnerId;
$partnerKey=$format->partnerKey;
$host=$format->host;
 

        $path = "/api/v2/shop/auth_partner";
        $redirectUrl=route('shopeeconnect',['marketplace'=>123]);
 

        $timest = time();
        $baseString = sprintf("%s%s%s", $partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $partnerKey);

        $shopeeConnectUrl = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&redirect=%s", $host, $path, $partnerId, $timest, $sign, $redirectUrl);

        $this->halaman->buttonIndex = ['Connect to Shopee'=>$shopeeConnectUrl];

        //test API: menampilkan informasi toko 
        $company = session('company');
        $token = DB::table('shopee_tokens')->find(2);
	if(!empty($token)){
        $shopeeShopId = $token->shop_id;
        $accessToken = $token->access_token;
        $refreshToken = $token->refresh_token;

        if (!empty($accessToken)){
            $path = "/api/v2/shop/get_shop_info";
            $curl = curl_init();
            $timest = time();
            $baseString = sprintf("%s%s%s%s%s", $partnerId, $path, $timest, $accessToken, $shopeeShopId);
            $sign = hash_hmac('sha256', $baseString, $partnerKey);
            $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&access_token=%s&shop_id=%s", $host, $path, $partnerId, $timest, $sign, $accessToken,$shopeeShopId);

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $ret = json_decode($response, true);


            
            if (!empty($ret['error'])){
                $newToken = $shopeeController->refreshAccessToken($shopeeShopId, $refreshToken);
                if(!empty($newToken['error'])) $ret = $newToken;
                else{
                $accessToken = $newToken['access_token'];
                
                $baseString = sprintf("%s%s%s%s%s", $partnerId, $path, $timest, $accessToken, $shopeeShopId);
                $sign = hash_hmac('sha256', $baseString, $partnerKey);
                $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&access_token=%s&shop_id=%s", $host, $path, $partnerId, $timest, $sign, $accessToken,$shopeeShopId);

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                $ret = json_decode($response, true);
                }
	    }
	    
        
        if(empty($ret)) $infoToko = "return kosong, sambungkan dulu akun tokonya";
	    else {
            
            if (!empty($ret['error'])) $infoToko = 'error: '.$ret['message'].'coba sambungkan dulu tokonya';
            	else $infoToko = $ret['shop_name']; }
        } else $infoToko = "belum ada access token, sambungkan dulu akun tokonya";
        } else {
            $infoToko = "belum ada access token, sambungkan dulu akun tokonya";
	}

        $this->halaman->infoIndex= ['nama toko shopee' => ['icon'=>'shop', 'isi'=>$infoToko]];

    }
}
