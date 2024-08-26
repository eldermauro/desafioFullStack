<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    protected $fillable = [
        'nome', // Certifique-se de que o campo é chamado 'nome' no modelo e na tabela
        'descricao',
        'preco',
        'data_validade',
        'categoria',
        'imagem',
    ];
}
