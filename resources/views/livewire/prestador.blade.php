<div>
    @section('title', 'Prestador')
    <x-nav />
    <x-lista.prestador :lista="$prestador"/>
    <x-modal.prestador :empresa="$empresa"/>
</div>
