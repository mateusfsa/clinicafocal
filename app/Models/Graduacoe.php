<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Graduacoe extends Model
{
    use HasFactory;

    protected $fillable = [
        'agendamento_id',
        'longe_od_esferico',
        'longe_od_cilindrico',
        'longe_od_eixo',
        'longe_od_dnp',
        'longe_oe_esferico',
        'longe_oe_cilindrico',
        'longe_oe_eixo',
        'longe_oe_dnp',
        'perto_od_esferico',
        'perto_od_cilindrico',
        'perto_od_eixo',
        'perto_od_dnp',
        'perto_oe_esferico',
        'perto_oe_cilindrico',
        'perto_oe_eixo',
        'perto_oe_dnp',
        'adicao_od',
        'adicao_oe',
        'observacoes',
    ];

    /**
     * Relacionamento com agendamento
     */
    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }

    /**
     * Verifica se a graduação está completa
     */
    public function estaCompleta(): bool
    {
        return !empty($this->longe_od_esferico) &&
            !empty($this->longe_oe_esferico) &&
            !empty($this->adicao);
    }
}
