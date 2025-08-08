<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'data_nascimento',
        'cpf',
        'cep',
        'rua',
        'n_casa',
        'bairro',
        'cidade',
        'uf',
        'observacoes',
    ];
    
    protected $casts = [
        'data_nascimento' => 'date',
    ];

    /**
     * Relacionamento com agendamentos
     */
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }

    /**
     * Acessor para idade do paciente
     */
    public function getIdadeAttribute(): int
    {
        return $this->data_nascimento->age;
    }
}
