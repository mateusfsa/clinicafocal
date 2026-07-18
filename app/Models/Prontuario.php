<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prontuario extends Model
{
    use Auditavel, HasFactory;

    protected $table = 'prontuarios';

    protected $fillable = [
        'agendamento_id',
        'queixa_principal',
        'historia_doenca',
        'antecedentes',
        'medicamentos_em_uso',
        'alergias',
        'av_od_sc',
        'av_oe_sc',
        'av_od_cc',
        'av_oe_cc',
        'pio_od',
        'pio_oe',
        'biomicroscopia',
        'fundoscopia',
        'diagnostico',
        'cid',
        'conduta',
    ];

    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class);
    }
}
