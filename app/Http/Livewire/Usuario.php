<?php

namespace App\Http\Livewire;

use App\Models\PrestadorBD;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Usuario extends Component
{
    use WithPagination;

    public $nome;

    public $idItem;

    public $sn_ativo;

    public $email;

    public $cpf;

    public $prestador_id;

    public $search = '';

    public $role;

    public $telefone;

    protected $messages = [
        'nome.required' => 'O campo é obrigatório.',
        'idItem.required' => 'O campo é obrigatório',
        'sn_ativo.required' => 'O campo é obrigatório',
        'prestador_id.required' => 'O campo é obrigatório',
        'email.required' => 'O campo é obrigatório',
        'required' => 'O campo é obrigatório',
    ];

    protected $rules = [
        'nome' => 'min:3|required',
        'sn_ativo' => 'required',
        'email' => 'required|unique:users|email',
        'role' => 'required',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $usuario = User::with('prestador')->search('nome', $this->search)->paginate(10);
        $prestador = PrestadorBD::where('sn_ativo', 'S')->get();

        return view('livewire.usuario', compact('usuario', 'prestador'));
    }

    public function updated($propertyName)
    {
        if ($this->idItem != '') {
            $this->rules['idItem'] = 'required';
        }
        if ($this->role == 'prestador') {
            $this->rules['prestador_id'] = 'required';
        }

        $this->validateOnly($propertyName, $this->rules);
    }

    public function openModal()
    {
        $this->nome = '';
        $this->cpf = '';
        $this->idItem = '';
        $this->email = '';
        $this->telefone = '';
        $this->sn_ativo = 'S';
        $this->prestador_id = '';
    }

    public function create()
    {

        if ($this->role == 'prestador') {
            $this->rules['prestador_id'] = 'required';
        }

        if ($this->idItem == '') {
            $this->validate();

            User::create([
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'role' => $this->role,
                'email' => $this->email,
                'prestador_id' => $this->prestador_id == '' ? null : $this->prestador_id,
                'sn_ativo' => $this->sn_ativo,
                'password' => Hash::make($this->cpf),
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Cadastro realizado com sucesso!!',
            ]);
        } else {

            $this->rules['email'] = "unique:users,email,$this->idItem,id";
            $this->rules['idItem'] = 'required';
            $this->validate();

            User::find($this->idItem)->update([
                'nome' => $this->nome,
                'cpf' => $this->cpf,
                'telefone' => $this->telefone,
                'role' => $this->role,
                'email' => $this->email,
                'prestador_id' => $this->prestador_id == '' ? null : $this->prestador_id,
                'sn_ativo' => $this->sn_ativo,
            ]);

            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => 'Atualização realizada com sucesso!!',
            ]);

        }

        $this->dispatchBrowserEvent('closeModal');
        $this->openModal();
    }

    public function edit(User $usuario)
    {
        $this->nome = $usuario->nome;
        $this->idItem = $usuario->id;
        $this->cpf = $usuario->cpf;
        $this->sn_ativo = $usuario->sn_ativo;
        $this->prestador_id = $usuario->prestador_id;
        $this->role = $usuario->role;
        $this->email = $usuario->email;
    }
}
