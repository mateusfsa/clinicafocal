<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caixa extends Model
{
    use Auditavel;

    protected $table = 'caixas';

    protected $fillable = [
        'user_abertura_id',
        'user_fechamento_id',
        'valor_abertura',
        'valor_fechamento',
        'aberto_em',
        'fechado_em',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'valor_abertura' => 'decimal:2',
        'valor_fechamento' => 'decimal:2',
        'aberto_em' => 'datetime',
        'fechado_em' => 'datetime',
    ];

    const STATUS_ABERTO = 'aberto';
    const STATUS_FECHADO = 'fechado';

    public function userAbertura(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_abertura_id');
    }

    public function userFechamento(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_fechamento_id');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(Pagamento::class);
    }

    public function scopeAberto($query)
    {
        return $query->where('status', self::STATUS_ABERTO);
    }

    /**
     * Caixa atualmente aberto (se houver)
     */
    public static function atual(): ?self
    {
        return static::aberto()->latest('aberto_em')->first();
    }

    /**
     * Total recebido em pagamentos enquanto o caixa esteve aberto
     */
    public function getTotalRecebidoAttribute(): float
    {
        return (float) $this->pagamentos()->sum('valor');
    }

    /**
     * Valor esperado no fechamento (abertura + recebimentos)
     */
    public function getValorEsperadoAttribute(): float
    {
        return (float) $this->valor_abertura + $this->total_recebido;
    }
}
