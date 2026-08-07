<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = [
        'title',
        'organization',
        'type',
        'description',
        'position',
        'date',
        'image',
        'url',
    ];


    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
