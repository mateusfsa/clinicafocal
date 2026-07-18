<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conta extends Model
{
    use Auditavel;

    protected $table = 'contas';

    protected $fillable = [
        'tipo',
        'descricao',
        'categoria',
        'valor',
        'vencimento',
        'pago_em',
        'forma_pagamento',
        'paciente_id',
        'convenio_id',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'vencimento' => 'date',
        'pago_em' => 'date',
    ];

    const TIPO_PAGAR = 'pagar';
    const TIPO_RECEBER = 'receber';

    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    public function convenio(): BelongsTo
    {
        return $this->belongsTo(Convenio::class);
    }

    public function scopeAbertas($query)
    {
        return $query->whereNull('pago_em');
    }

    public function scopeVencidas($query)
    {
        return $query->whereNull('pago_em')->whereDate('vencimento', '<', today());
    }

    /**
     * Situação calculada: paga, vencida ou aberta
     */
    public function getSituacaoAttribute(): string
    {
        if ($this->pago_em) {
            return 'paga';
        }

        return $this->vencimento->isPast() && ! $this->vencimento->isToday() ? 'vencida' : 'aberta';
    }
}
