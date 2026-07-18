<?php

namespace App\Models;

use App\Models\Concerns\Auditavel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Medico extends Model
{
    use Auditavel, HasFactory;

    protected $table = 'medicos';

    protected $fillable = [
        'nome',
        'crm',
        'crm_uf',
        'especialidade',
        'telefone',
        'email',
        'ativo',
        'user_id',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    /**
     * Usuário do sistema vinculado ao médico (login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Agendamentos do médico
     */
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class);
    }

    /**
     * Pagamentos recebidos via agendamentos do médico
     */
    public function pagamentos(): HasManyThrough
    {
        return $this->hasManyThrough(Pagamento::class, Agendamento::class);
    }

    /**
     * Escopo: apenas médicos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * CRM formatado com UF (ex: 12345/SP)
     */
    public function getCrmCompletoAttribute(): string
    {
        return "{$this->crm}/{$this->crm_uf}";
    }
}
