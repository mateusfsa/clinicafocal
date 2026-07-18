<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Concerns\Auditavel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Auditavel, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     *
     * Nota: 'tipo' é gerenciado apenas pelo UserResource (admin-only);
     * o registro público está desativado e o perfil só valida name/email.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tipo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    const TIPO_ATENDENTE = 'atendente';
    const TIPO_MEDICO = 'medico';
    const TIPO_ADMIN = 'admin';
    const TIPO_PACIENTE = 'paciente';

    /**
     * Tipos autorizados a acessar o painel Filament.
     * Usuários sem tipo definido (ou pacientes) NÃO têm acesso.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->tipo, [
            self::TIPO_ADMIN,
            self::TIPO_MEDICO,
            self::TIPO_ATENDENTE,
        ], true);
    }

    /**
     * É usuário da equipe (acessa o painel administrativo)
     */
    public function isStaff(): bool
    {
        return in_array($this->tipo, [
            self::TIPO_ADMIN,
            self::TIPO_MEDICO,
            self::TIPO_ATENDENTE,
        ], true);
    }

    /**
     * Verifica se o usuário é paciente (portal)
     */
    public function isPaciente(): bool
    {
        return $this->tipo === self::TIPO_PACIENTE;
    }

    /**
     * Cadastro de paciente vinculado a este login
     */
    public function paciente()
    {
        return $this->hasOne(Paciente::class);
    }

    /**
     * Verifica se o usuário é médico
     */
    public function isMedico(): bool
    {
        return $this->tipo === self::TIPO_MEDICO;
    }

    /**
     * Verifica se o usuário é atendente
     */
    public function isAtendente(): bool
    {
        return $this->tipo === self::TIPO_ATENDENTE;
    }

    /**
     * Verifica se o usuário é admin
     */
    public function isAdmin(): bool
    {
        return $this->tipo === self::TIPO_ADMIN;
    }
}
