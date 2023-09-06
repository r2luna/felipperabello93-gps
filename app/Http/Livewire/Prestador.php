<?php

namespace App\Http\Livewire;

use App\Models\EmpresaBD;
use App\Models\PrestadorBD;
use Livewire\Component;
use Livewire\WithPagination;

class Prestador extends Component
{
    use WithPagination;

    public $nome;

    public $idItem;

    public $sn_ativo;

    public $cpf;

    public $telefone;

    public $empresa_id;

    public $search = '';

    protected $messages = [
        'nome.required' => 'O campo é obrigatório.',
        'idItem.required' => 'O campo é obrigatório',
        'sn_ativo.required' => 'O campo é obrigatório',
        'empresa_id.required' => 'O campo é obrigatório',
    ];

    protected $rules = [
        'nome' => 'min:3|required',
        'sn_ativo' => 'required',
        'empresa_id' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prestador = PrestadorBD::with('empresa')->search('nome', $this->search)->paginate(10);
        $empresa = EmpresaBD::where('sn_ativo', 'S')->get();

        return view('livewire.prestador', compact('prestador', 'empresa'));
    }

    public function updated($propertyName)
    {
        if ($this->idItem != '') {
            $this->rules['idItem'] = 'required';
        }

        $this->validateOnly($propertyName, $this->rules);
    }

    public function openModal()
    {
        $this->nome = '';
        $this->cpf = '';
        $this->telefone = '';
        $this->idItem = '';
        $this->sn_ativo = 'S';
        $this->empresa_id = '';
    }

    public function create()
    {

        if ($this->idItem == '') {
            $this->validate();

            PrestadorBD::create([
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'empresa_id' => $this->empresa_id,
                'sn_ativo' => $this->sn_ativo,
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Cadastro realizado com sucesso!!',
            ]);
        } else {
            $this->rules['idItem'] = 'required';
            $this->validate($this->rules);
            PrestadorBD::find($this->idItem)
                ->update([
                    'nome' => $this->nome,
                    'sn_ativo' => $this->sn_ativo,
                    'cpf' => $this->cpf,
                    'empresa_id' => $this->empresa_id,
                    'telefone' => $this->telefone,
                ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Atualização realizada com sucesso!!',
            ]);

        }

        $this->dispatchBrowserEvent('closeModal');
        $this->openModal();
    }

    public function edit(PrestadorBD $prestador)
    {
        $this->nome = $prestador->nome;
        $this->idItem = $prestador->id;
        $this->cpf = $prestador->cpf;
        $this->telefone = $prestador->telefone;
        $this->sn_ativo = $prestador->sn_ativo;
        $this->empresa_id = $prestador->empresa_id;
    }
}
