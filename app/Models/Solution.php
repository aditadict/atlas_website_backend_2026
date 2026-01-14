<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasUuids;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'icon',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];
}
