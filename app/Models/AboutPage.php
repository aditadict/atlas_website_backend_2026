<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    use HasUuids;

    protected $fillable = [
        'years_experience',
        'systems_delivered',
        'industries_served',
        'headline',
        'subheadline',
        'story',
        'mission',
        'vision',
        'is_active',
    ];

    protected $casts = [
        'headline' => 'array',
        'subheadline' => 'array',
        'story' => 'array',
        'mission' => 'array',
        'vision' => 'array',
        'is_active' => 'boolean',
    ];
}
