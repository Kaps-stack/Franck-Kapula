<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'institution',
        'degree',
        'field',
        'description',
        'location',
        'start_date',
        'end_date',
        'current',
        'institution_url',
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
