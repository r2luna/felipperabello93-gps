<?php

namespace App\Http\Trait;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

trait RoutesT
{
    // public function RouteDashboard()
    // {
    //     return redirect()->route('dashboard');
    // }

    public function setredirectRoute($route)
    {
        $this->rota = $route;
        return redirect()->route($this->rota);
    }
}
