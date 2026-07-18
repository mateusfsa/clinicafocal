<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitacaoAgendamento extends Model
{
    use HasFactory;

    protected $table = 'solicitacoes_agendamento';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'medico_id',
        'data_preferida',
        'periodo',
        'mensagem',
        'consentimento',
        'status',
        'agendamento_id',
    ];

    protected $casts = [
        'data_preferida' => 'date',
        'consentimento' => 'boolean',
    ];

    const STATUS_PENDENTE = 'pendente';
    const STATUS_CONFIRMADA = 'confirmada';
    const STATUS_RECUSADA = 'recusada';

    const PERIODO_MANHA = 'manha';
    const PERIODO_TARDE = 'tarde';

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }

    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }
}
