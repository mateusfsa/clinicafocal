<?php

namespace App\Listeners;

use App\Models\Acesso;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

/**
 * Registra eventos de autenticação na tabela de acessos
 * (requisito de auditoria: registro de acessos).
 */
class RegistrarAcesso
{
    public function handle(Login|Logout|Failed $event): void
    {
        $evento = match (true) {
            $event instanceof Login => Acesso::EVENTO_LOGIN,
            $event instanceof Logout => Acesso::EVENTO_LOGOUT,
            $event instanceof Failed => Acesso::EVENTO_FALHA,
        };

        Acesso::create([
            'user_id' => $event->user?->getAuthIdentifier(),
            'email' => $event->user->email ?? ($event->credentials['email'] ?? null),
            'evento' => $evento,
            'ip' => request()->ip(),
            'user_agent' => substr((string) request()->userAgent(), 0, 255),
        ]);
    }
}
