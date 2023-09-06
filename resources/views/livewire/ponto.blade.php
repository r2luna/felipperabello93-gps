<div>
    @section('title', 'Ponto')
    <x-nav />

    @can('edit articles2')
    I am a writer!
    @endcan


    <x-lista.ponto :lista="$ponto"/>
    @vite(['resources/js/gps.js'])
</div>
