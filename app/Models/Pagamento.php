<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pagamento extends Model
{
    use Auditavel, HasFactory;

    protected $fillable = [
        'agendamento_id',
        'caixa_id',
        'valor',
        'forma_pagamento',
    ];

    protected static function booted(): void
    {
        // Vincula automaticamente o pagamento ao caixa aberto
        static::creating(function (Pagamento $pagamento) {
            if (! $pagamento->caixa_id) {
                $pagamento->caixa_id = Caixa::atual()?->id;
            }
        });
    }

    const FORMA_DINHEIRO = 'dinheiro';
    const FORMA_CARTAO_DEBITO = 'cartao_debito';
    const FORMA_CARTAO_CREDITO = 'cartao_credito';
    const FORMA_PIX = 'pix';

    /**
     * Relacionamento com agendamento
     */
    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    /**
     * Caixa em que o pagamento foi registrado
     */
    public function caixa(): BelongsTo
    {
        return $this->belongsTo(Caixa::class);
    }

    /**
     * Acessor para valor formatado
     */
    public function getValorFormatadoAttribute(): string
    {
        return 'R$ ' . number_format($this->valor, 2, ',', '.');
    }

    /**
     * Acessor para forma de pagamento formatada
     */
    public function getFormaPagamentoFormatadaAttribute(): string
    {
        $formas = [
            self::FORMA_DINHEIRO => 'Dinheiro',
            self::FORMA_CARTAO_DEBITO => 'Cartão de Débito',
            self::FORMA_CARTAO_CREDITO => 'Cartão de Crédito',
            self::FORMA_PIX => 'PIX',
        ];

        return $formas[$this->forma_pagamento] ?? $this->forma_pagamento;
    }
}
