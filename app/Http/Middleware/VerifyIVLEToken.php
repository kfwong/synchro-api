<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class VerifyIVLEToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        $client = new Client();

        $options = [
            'query' => [
                'APIKey' => getenv('IVLE_API_KEY'),
                'Token' => $token
            ]
        ];

        $res_ivle_token_validate = $client->get("https://ivle.nus.edu.sg/api/Lapi.svc/Validate", $options);

        $res_ivle_token_validate_json = json_decode($res_ivle_token_validate->getBody());

        if($res_ivle_token_validate_json->Success){

            if(!$request->has("ivle_id")){
                $res_ivle_user_id = $client->get("https://ivle.nus.edu.sg/api/Lapi.svc/UserID_Get", $options);

                $res_ivle_user_id_json = json_decode($res_ivle_user_id->getBody());

                $request->session()->put("ivle_id", $res_ivle_user_id_json);
            }

            return $next($request);
        }else{
            abort(Response::HTTP_UNAUTHORIZED, 'Expired or invalid IVLE Token.');
        }

    }
}
