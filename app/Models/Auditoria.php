<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Auditoria extends Model
{
    protected $table = 'auditorias';

    protected $fillable = [
        'user_id',
        'acao',
        'auditavel_type',
        'auditavel_id',
        'alteracoes',
        'ip',
    ];

    protected $casts = [
        'alteracoes' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditavel(): MorphTo
    {
        return $this->morphTo();
    }
}
