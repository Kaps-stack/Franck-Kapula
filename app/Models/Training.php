<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'title',
        'organization',
        'description',
        'category',
        'start_date',
        'end_date',
        'duration',
        'location',
        'certificate_file',
        'url',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration' => 'integer',
        ];
    }
}
