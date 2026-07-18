<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agendamento extends Model
{
    use Auditavel, HasFactory;

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'convenio_id',
        'data_hora',
        'status',
    ];

    protected $casts = [
        'data_hora' => 'datetime',
    ];

    const STATUS_AGENDADO = 'agendado';
    const STATUS_COMPARECEU = 'compareceu';
    const STATUS_EM_ATENDIMENTO = 'em_atendimento';
    const STATUS_FINALIZADO = 'finalizado';
    const STATUS_CANCELADO = 'cancelado';

    /**
     * Relacionamento com paciente
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Relacionamento com médico
     */
    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class);
    }

    /**
     * Convênio do atendimento (null = particular)
     */
    public function convenio(): BelongsTo
    {
        return $this->belongsTo(Convenio::class);
    }

    /**
     * Relacionamento com pagamento
     */
    public function pagamento(): HasOne
    {
        return $this->hasOne(Pagamento::class);
    }

    /**
     * Relacionamento com graduação
     */
    public function graduacoe(): HasOne
    {
        return $this->hasOne(Graduacoe::class);
    }

    /**
     * Prontuário do atendimento
     */
    public function prontuario(): HasOne
    {
        return $this->hasOne(Prontuario::class);
    }

    /**
     * Relacionamento com receita
     */
    public function receita(): HasOne
    {
        return $this->hasOne(Receita::class);
    }

    /**
     * Escopo para agendamentos do dia
     */
    public function scopeHoje($query)
    {
        return $query->whereDate('data_hora', today());
    }

    /**
     * Escopo para agendamentos por status
     */
    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
