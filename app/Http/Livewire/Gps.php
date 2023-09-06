<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;

class Gps extends Component
{
    public $lon;

    public $lat;

    public $retorno;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
    ];

    public function setLatitudeLongitude($latitude, $longitude)
    {
        $this->lat = $latitude;
        $this->lon = $longitude;
    }

    public function render()
    {
        return view('livewire.gps');
    }

    public function getGps()
    {
        $url = 'https://nominatim.openstreetmap.org/reverse';
        $header = [];
        $params = [
            'format' => 'json',
            'lon' => $this->lon,
            'lat' => $this->lat,
        ];

        $processo = new Client();
        //$processo = $processo->get($url);
        $processo = $processo->get($url, ['query' => $params,  'http_errors' => false, 'allow_redirects' => false]);

        $code = $processo->getStatusCode();

        if ($code == 200) {

            $processo = $processo->getBody()->getContents();
            $processo = collect(json_decode(($processo)));

            $this->retorno = $processo['display_name'];

            //$processo['address']->residential;

        }

    }
}
