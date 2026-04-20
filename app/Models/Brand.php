<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo_url',
        'website',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
