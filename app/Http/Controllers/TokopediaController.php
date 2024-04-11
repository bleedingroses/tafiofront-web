<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class TokopediaController extends Controller
    {
        public function connect(Request $request)
        {
            $clientId = env('TOKOPEDIA_CLIENT_ID');
            $clientSecret = env('TOKOPEDIA_CLIENT_SECRET');

            $authorizationHeader = base64_encode("$clientId:$clientSecret");
            $headers = array(
                "Authorization: Basic $authorizationHeader",
                "Content-Length: 0",
                "User-Agent: PHP"
            );

            $url = "https://accounts.tokopedia.com/token?grant_type=client_credentials";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            dd($response); // This will output the token response

        if ($response->status() == 200) {
            $data = json_decode($response->body());

            $token = $data['access_token'];
            $expires_in = $data['expires_in'];

            // Store the token in the database
            $this->storeToken($token, $expires_in);

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
            ]);
        }
    }

    public function refreshToken()
    {
        $token = $this->getTokenFromDatabase();

        if ($token === null) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found',
            ]);
        }

        $client_id = config('tokopedia.client_id');
        $client_secret = config('tokopedia.client_secret');

        $response = Http::post('https://accounts.tokopedia.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token['refresh_token'],
            'client_id' => $client_id,
            'client_secret' => $client_secret,
        ]);

        if ($response->status() == 200) {
            $data = json_decode($response->body());

            $token = $data['access_token'];
            $expires_in = $data['expires_in'];

            // Store the token in the database
            $this->storeToken($token, $expires_in);

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
            ]);
        }
    }

    private function storeToken($token, $expires_in)
    {
        $expires_at = time() + $expires_in;

        $data = [
            'token' => $token,
            'expires_at' => $expires_at,
        ];

        \DB::table('tokopedia_tokens')->insert($data);
    }

    private function getTokenFromDatabase()
    {
        return \DB::table('tokopedia_tokens')->where('expires_at', '>', time())->first();
    }
}
