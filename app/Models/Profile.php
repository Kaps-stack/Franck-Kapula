<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'full_name',
        'title',
        'bio',
        'location',
        'email',
        'phone',
        'avatar',
        'cv',
        'github_url',
        'linkedin_url',
        'website_url',
        'facebook_url',
        'X_url',
        'instagram_url',
        'whatsapp_url',
    ];
}
