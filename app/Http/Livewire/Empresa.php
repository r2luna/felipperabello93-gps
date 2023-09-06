<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EmpresaBD;
use Illuminate\Support\Facades\Auth;
use App\Http\Trait\RoutesT;




class Empresa extends Component
{

    use WithPagination;
    use RoutesT;

    public $nome;
    public $idItem;
    public $sn_ativo;
    public $cnpj;
    public $endereco;
    public $search = "";
    public $rota;


    protected $messages = [
        'nome.required' => 'O campo é obrigatório.',
        'idItem.required' =>'O campo é obrigatório',
        'sn_ativo.required' => 'O campo é obrigatório',
    ];

    protected $rules =  [
        'nome' => 'min:3|required',
        'sn_ativo' => 'required'
    ];

    protected $listeners = [
        'set:redirectRoute' => 'setredirectRoute'
    ];




    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $empresa = EmpresaBD::search('nome', $this->search)->paginate(10);

        return view('livewire.empresa', compact('empresa'));
    }

    public function updated($propertyName)
    {
        if($this->idItem != "")
        {
            $this->rules['idItem'] = 'required';
        }


        $this->validateOnly($propertyName, $this->rules);
    }

    public function openModal()
    {
        $this->nome = "";
        $this->cnpj = "";
        $this->endereco = "";
        $this->idItem = "";
        $this->sn_ativo = "S";
    }

    public function create()
    {



        if($this->idItem == "")
        {

            $this->validate();


            EmpresaBD::create([
                'nome' => $this->nome,
                'cnpj' => $this->cnpj,
                'endereco' => $this->endereco,
                'sn_ativo' => $this->sn_ativo,
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Cadastro realizado com sucesso!!",
            ]);
        }
        else
        {
            $this->rules['idItem'] = 'required';
            $this->validate($this->rules);
            EmpresaBD::find($this->idItem)
                      ->update([
                                'nome' => $this->nome,
                                'sn_ativo' => $this->sn_ativo,
                                'cnpj' => $this->cnpj,
                                'endereco' => $this->endereco
                            ]);


                      $this->dispatchBrowserEvent('alert', [
                        'type' => 'success',
                        'message' => "Atualização realizada com sucesso!!",
                    ]);

        }

        $this->dispatchBrowserEvent('closeModal');
        $this->openModal();
    }

    public function edit(EmpresaBD $empresa)
    {
        $this->nome = $empresa->nome;
        $this->idItem = $empresa->id;
        $this->cnpj = $empresa->cnpj;
        $this->endereco = $empresa->endereco;
        $this->sn_ativo = $empresa->sn_ativo;
    }
}
