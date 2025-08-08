<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    /**
     * Verifica se o usuário pode acessar o painel Filament
     */
    public function canAccessFilament(): bool
    {
        return true;
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
