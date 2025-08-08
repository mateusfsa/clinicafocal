<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'url',
        'order',
        'is_active'
    ];

    /**
     * Escopo para filtrar apenas itens ativos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    

    /**
     * Escopo para ordenar pelos itens pelo campo 'order'
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
