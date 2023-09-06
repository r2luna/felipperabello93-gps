<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Trait\RoutesT;

class Dashboard extends Component
{
    use WithPagination;
    use RoutesT;

    public $rota;

    protected $listeners = [
        'set:redirectRoute' => 'setredirectRoute'
    ];


    public function render()
    {
        return view('livewire.dashboard');
    }
}
