<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'link', 'order', 'active'];
}
