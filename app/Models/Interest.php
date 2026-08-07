<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'description',
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
