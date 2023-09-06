<?php

namespace App\Http\Livewire;

use App\Models\PontoBD;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Ponto extends Component
{
    use WithPagination;

    public $search = '';

    public $latitude;

    public $longitude;

    public $accuracy;

    public $endereco_completo;

    public $endereco;

    public $cidade;

    public $cep;

    public $PontoNoDia;

    protected $listeners = [
        'set:latitude-longitude' => 'setLatitudeLongitude',
    ];

    public function setLatitudeLongitude($latitude, $longitude, $accuracy)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->accuracy = $accuracy;
    }

    public function getGps()
    {
        $url = 'https://nominatim.openstreetmap.org/reverse';
        $header = [];
        $params = [
            'format' => 'json',
            'lon' => $this->longitude,
            'lat' => $this->latitude,
        ];

        $processo = new Client();
        //$processo = $processo->get($url);
        $processo = $processo->get($url, ['query' => $params,  'http_errors' => false, 'allow_redirects' => false]);

        $code = $processo->getStatusCode();

        if ($code == 200) {

            $processo = $processo->getBody()->getContents();
            $processo = collect(json_decode(($processo)));

            $this->endereco_completo = $processo['display_name'];
            $this->endereco = $processo['name'];
            $this->cidade = $processo['addresstype'] == 'road' ? $processo['address']->city : null;
            $this->cep = $processo['addresstype'] == 'road' ? $processo['address']->postcode : null;

        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $ponto = PontoBD::with('usuario')->with('prestador')->search('dia', $this->search)->paginate(10);

        return view('livewire.ponto', compact('ponto'));
    }

    public function create()
    {
        $sysdate = Carbon::now();
        $dia = $sysdate->format('Y-m-d');

        $this->PontoNoDia = PontoBD::where('user_id', Auth::user()->id)->where('dia', $dia)->get();

        $PontoEntrada = $this->PontoNoDia->where('tipo', 'E');
        $PontoSaida = $this->PontoNoDia->where('tipo', 'S');

        if (count($PontoEntrada) == 0) {
            $this->getGps();

            PontoBD::create([
                'user_id' => Auth::user()->id,
                'prestador_id' => Auth::user()->prestador_id,
                'dia' => $dia,
                'data_hora' => $sysdate->format('Y-m-d h:i'),
                'tipo' => 'E',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'accuracy' => $this->accuracy,
                'endereco_completo' => $this->endereco_completo,
                'endereco' => $this->endereco,
                'cidade' => $this->cidade,
                'cep' => $this->cep,
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Ponto registrado com sucesso!!',
            ]);
        } elseif (count($PontoSaida) == 0) {
            $totalDuration = $sysdate->diffForHumans($PontoEntrada[0]->data_hora, true, true, 2);

            $this->getGps();

            PontoBD::create([
                'user_id' => Auth::user()->id,
                'prestador_id' => Auth::user()->prestador_id,
                'dia' => $dia,
                'data_hora' => $sysdate->format('Y-m-d h:i'),
                'tipo' => 'S',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'accuracy' => $this->accuracy,
                'endereco_completo' => $this->endereco_completo,
                'endereco' => $this->endereco,
                'cidade' => $this->cidade,
                'cep' => $this->cep,
                'tempo_trabalho' => $totalDuration,
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Ponto registrado com sucesso!!',
            ]);
        } else {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => 'Você já registrou o seu ponto hoje!!',
            ]);
        }

    }
}
