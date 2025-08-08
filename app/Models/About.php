<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description_1', 
        'description_2', 
        'image', 
        'features'
    ];

    protected $casts = [
        'features' => 'array',
    ];
}
