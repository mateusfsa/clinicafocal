<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receita extends Model
{
    use HasFactory;

    protected $fillable = [
        'agendamento_id',
        'medicamentos',
        'instrucoes',
    ];

    /**
     * Relacionamento com agendamento
     */
    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    /**
     * Acessor para medicamentos como array
     */
    public function getMedicamentosArrayAttribute(): array
    {
        return explode("\n", $this->medicamentos);
    }

    /**
     * Acessor para instruções como array
     */
    public function getInstrucoesArrayAttribute(): array
    {
        return explode("\n", $this->instrucoes);
    }
}
