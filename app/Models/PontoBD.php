<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoBD extends Model
{
    use HasFactory;

    protected $table = 'ponto';

    protected $fillable = ['user_id', 'prestador_id', 'tempo_trabalho', 'tipo', 'data_hora', 'dia', 'data_saida', 'latitude', 'longitude', 'accuracy', 'endereco_completo', 'endereco', 'cidade', 'cep'];

    public function prestador()
    {
        return $this->belongsTo(PrestadorBD::class, 'prestador_id', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
