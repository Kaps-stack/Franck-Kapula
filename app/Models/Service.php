<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'order',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'featured' => 'boolean',
        ];
    }
}
