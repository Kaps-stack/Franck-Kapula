<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image',
        'demo_url',
        'github_url',
        'category',
        'status',
        'featured',
        'start_date',
        'end_date',
    ];

    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
