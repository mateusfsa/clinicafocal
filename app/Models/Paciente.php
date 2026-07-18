<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use Auditavel;

    protected $fillable = [
        'user_id',
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
        'convenio_id',
        'numero_carteirinha',
        'validade_carteirinha',
        'consentimento_lgpd',
        'consentimento_lgpd_em',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'validade_carteirinha' => 'date',
        'consentimento_lgpd' => 'boolean',
        'consentimento_lgpd_em' => 'datetime',
    ];

    protected static function booted(): void
    {
        // Registra o momento em que o consentimento LGPD foi dado
        static::saving(function (Paciente $paciente) {
            if ($paciente->isDirty('consentimento_lgpd') && $paciente->consentimento_lgpd && ! $paciente->consentimento_lgpd_em) {
                $paciente->consentimento_lgpd_em = now();
            }
        });
    }

    /**
     * Login do paciente no portal
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Convênio do paciente
     */
    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }

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
