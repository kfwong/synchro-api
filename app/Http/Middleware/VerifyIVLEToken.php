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

        $response = $client->get("https://ivle.nus.edu.sg/api/Lapi.svc/Validate", [
            'query' => [
                'APIKey' => getenv('IVLE_API_KEY'),
                'Token' => $token
            ]
        ]);

        $response_json = json_decode($response->getBody());

        if($response_json->Success){
            return $next($request);
        }else{
            abort(Response::HTTP_UNAUTHORIZED, 'Expired or invalid IVLE Token.');
        }

    }
}
