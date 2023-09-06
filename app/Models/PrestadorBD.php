<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrestadorBD extends Model
{
    use HasFactory;

    protected $table = 'prestador';

    protected $fillable = ['nome', 'cpf', 'telefone', 'empresa_id', 'sn_ativo'];

    public function empresa()
    {
        return $this->belongsTo(EmpresaBD::class);
    }
}
