<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsightFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'insight_id',
        'ip_address',
        'is_helpful',
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    public function insight(): BelongsTo
    {
        return $this->belongsTo(Insight::class);
    }
}
