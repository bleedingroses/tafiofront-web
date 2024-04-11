<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Tafio\bisnis\src\Models\marketplaceFormat;
use App\Tafio\bisnis\src\Models\marketplaceConfig;
use Illuminate\Support\Facades\DB;

class ShopeeController extends Controller
{

public function kiriman()
{
 return response('', 200);

}


    public function connect($marketplace)
    {
        $code = request()->code; // Authorization code received from Shopee
        $shopId = (int)request()->shop_id;


$config=marketplaceConfig::find($marketplace);

        // Exchange authorization code for access token and refresh token
        $tokens = $this->exchangeCodeForToken($code, $shopId);

        $accessToken = $tokens['access_token'];
        $refreshToken = $tokens['refresh_token'];
 
        $toko=$this->ambil($shopId,$accessToken,"/api/v2/shop/get_shop_info");



        // Save shop ID, access token, and refresh token to database
        $config->update(
            ['shop_id' => $shopId,
            'access_token' => $accessToken, 
            'refresh_token' => $refreshToken,
            'autosinkron'=>$toko['shop_name'],
            ] 
        );

        return redirect('bisnis/jasa/marketplace')->with('message','shopee account berhasil disambungkan');
    }



    protected function ambil($shopId,$accessToken,$path)
{ 
$format = marketplaceFormat::shopee();
 
            $curl = curl_init();
            $timest = time();
            $baseString = sprintf("%s%s%s%s%s", $format->partnerId, $path, $timest, $accessToken, $shopId);
            $sign = hash_hmac('sha256', $baseString, $format->partnerKey);
            $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s&access_token=%s&shop_id=%s", $format->host, $path, $format->partnerId, $timest, $sign, $accessToken,$shopId);

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
            return json_decode($response, true);

        }

    
    


    protected function exchangeCodeForToken($code, $shopId)
    {



$format = marketplaceFormat::shopee();

        $path = "/api/v2/auth/token/get";
        $timest = time();
        $body = array("code" => $code,  "shop_id" => (int)$shopId, "partner_id" => $format->partnerId);
        $baseString = sprintf("%s%s%s", $format->partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $format->partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $format->host, $path, $format->partnerId, $timest, $sign);
 
        // dd($url);

        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $resp = curl_exec($c);

        $ret = json_decode($resp, true);
        //dd($partnerId);
            return [
                'access_token' => $ret['access_token'],
                'refresh_token' => $ret['refresh_token'],
        ];
    }

    public function refreshAccessToken($shopId, $refreshToken)
    {
        $path = "/api/v2/auth/access_token/get";
$format = marketplaceFormat::shopee();
        
$timest = time();
        $body = array("partner_id" => $format->partnerId, "shop_id" => (int)$format->shopId, "refresh_token" => $refreshToken);
        $baseString = sprintf("%s%s%s", $format->partnerId, $path, $timest);
        $sign = hash_hmac('sha256', $baseString, $format->partnerKey);
        $url = sprintf("%s%s?partner_id=%s&timestamp=%s&sign=%s", $format->host, $path, $format->partnerId, $timest, $sign);
    
    
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    
        $result = curl_exec($c);
    
        $ret = json_decode($result, true);
        if (!empty($ret["error"])){
            return $ret;
        } else {
            // Save new access token to database
            DB::table('shopee_tokens')->where('shop_id', $shopId)
                ->update(['access_token' => $ret['access_token'], 
                        'refresh_token' => $ret['refresh_token']]);

            return [
                'access_token' => $ret['access_token'],
                'refresh_token' => $ret['refresh_token'],
            ];
        }
    }
}
