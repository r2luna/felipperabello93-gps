<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GpsController extends Controller
{
    public function gps(Request $request)
    {
        $url = 'https://nominatim.openstreetmap.org/reverse';
        $header = [];
        $params = [
            'format' => 'json',
            'lon' => $request->lon,
            'lat' => $request->lat,
        ];

        $processo = new Client();
       // $processo = $processo->get($url);
        $processo = $processo->get($url, [ 'query' => $params,  'http_errors'  =>  false, 'allow_redirects' => false]);


        $code = $processo->getStatusCode();

        if($code == 200)
        {

        $processo= $processo->getBody()->getContents();
        $processo = collect(json_decode(($processo)));


        }

    }
}
