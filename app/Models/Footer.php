<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'about',
        'quick_links',
        'services',
        'copyright_text',
        'social_links',
        'newsletter_active'
    ];

    protected $casts = [
        'quick_links' => 'array',
        'services' => 'array',
        'social_links' => 'array'
    ];
}
