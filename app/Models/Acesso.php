<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Acesso extends Model
{
    protected $table = 'acessos';

    protected $fillable = [
        'user_id',
        'email',
        'evento',
        'ip',
        'user_agent',
    ];

    const EVENTO_LOGIN = 'login';
    const EVENTO_LOGOUT = 'logout';
    const EVENTO_FALHA = 'falha';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
