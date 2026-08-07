<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company',
        'position',
        'description',
        'location',
        'start_date',
        'end_date',
        'current',
        'company_url',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'current' => 'boolean',
        ];
    }
}
