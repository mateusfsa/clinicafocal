<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Convenio extends Model
{
    use Auditavel, HasFactory;

    protected $table = 'convenios';

    protected $fillable = [
        'nome',
        'registro_ans',
        'telefone',
        'email',
        'valor_consulta',
        'observacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'valor_consulta' => 'decimal:2',
    ];

    public function pacientes(): HasMany
    {
        return $this->hasMany(Paciente::class);
    }

    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}
