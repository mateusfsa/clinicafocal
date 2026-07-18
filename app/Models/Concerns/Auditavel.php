<?php

namespace App\Models\Concerns;

use App\Models\Auditoria;
use Illuminate\Database\Eloquent\Model;

/**
 * Registra automaticamente criação, alteração e exclusão
 * do model na tabela de auditorias (LGPD: histórico de tratamento de dados).
 */
trait Auditavel
{
    public static function bootAuditavel(): void
    {
        static::created(fn (Model $model) => static::registrarAuditoria($model, 'created'));
        static::updated(fn (Model $model) => static::registrarAuditoria($model, 'updated'));
        static::deleted(fn (Model $model) => static::registrarAuditoria($model, 'deleted'));
    }

    protected static function registrarAuditoria(Model $model, string $acao): void
    {
        $alteracoes = null;

        if ($acao === 'updated') {
            $novos = $model->getChanges();
            unset($novos['updated_at'], $novos['created_at'], $novos['password'], $novos['remember_token']);

            if (empty($novos)) {
                return;
            }

            $antes = [];
            foreach (array_keys($novos) as $campo) {
                $antes[$campo] = $model->getOriginal($campo);
            }

            $alteracoes = ['antes' => $antes, 'depois' => $novos];
        } elseif ($acao === 'created') {
            $atributos = $model->getAttributes();
            unset($atributos['password'], $atributos['remember_token']);
            $alteracoes = ['depois' => $atributos];
        }

        Auditoria::create([
            'user_id' => auth()->id(),
            'acao' => $acao,
            'auditavel_type' => $model->getMorphClass(),
            'auditavel_id' => $model->getKey(),
            'alteracoes' => $alteracoes,
            'ip' => app()->runningInConsole() ? null : request()->ip(),
        ]);
    }
}
