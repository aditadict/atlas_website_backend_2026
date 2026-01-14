<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Insight extends Model
{
    use HasFactory, HasUuids, HasSEO;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'category',
        'read_time',
        'published',
        'featured_image',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'category' => 'array',
        'published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get formatted created date for English locale
     *
     * @return string
     */
    public function getFormattedDateEnAttribute(): string
    {
        return $this->created_at->format('M j, Y');
    }

    /**
     * Get formatted created date for Indonesian locale
     *
     * @return string
     */
    public function getFormattedDateIdAttribute(): string
    {
        $months = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'Mei',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Agt',
            9 => 'Sep',
            10 => 'Okt',
            11 => 'Nov',
            12 => 'Des'
        ];

        $month = $months[$this->created_at->month];
        return $month . ' ' . $this->created_at->day . ', ' . $this->created_at->year;
    }

    /**
     * Append formatted dates to JSON output
     *
     * @var array
     */
    protected $appends = ['formatted_date_en', 'formatted_date_id'];

    /**
     * Get dynamic SEO data from the insight's content.
     * This provides fallback values if custom SEO fields are not set.
     *
     * @return SEOData
     */
    public function getDynamicSEOData(): SEOData
    {
        // Use English content as default for SEO
        $title = $this->title['en'] ?? $this->slug;
        $description = $this->excerpt['en'] ?? null;
        $image = $this->featured_image ? asset('storage/' . $this->featured_image) : null;

        return new SEOData(
            title: $title,
            description: $description,
            image: $image,
            published_time: $this->created_at,
            modified_time: $this->updated_at,
            section: $this->category['en'] ?? null,
            type: 'article',
        );
    }
}
