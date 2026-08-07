<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'name',
        'level',
        'percentage',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
            'featured' => 'boolean',
        ];
    }
}
