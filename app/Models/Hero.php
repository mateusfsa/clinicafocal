<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
     use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button1_text',
        'button1_link',
        'button2_text',
        'button2_link',
        'background_image',
        'is_active'
    ];
}
