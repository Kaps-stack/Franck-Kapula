<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'icon',
        'level',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'featured' => 'boolean',
        ];
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
