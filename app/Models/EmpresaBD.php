<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaBD extends Model
{
    use HasFactory;

    protected $table = 'empresa';
    protected $fillable = ['nome','cnpj','endereco','sn_ativo'];



}
