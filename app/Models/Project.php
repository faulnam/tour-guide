<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'client',
        'location',
        'size',
        'year',
        'description',
        'cover_image',
        'is_featured',
        'is_recent',
        'order',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_recent' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Service category
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Gallery images
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class, 'project_id')->orderBy('order');
    }

    /**
     * Scope for published projects
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured projects (home hero slider)
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for recent projects (home 3x3 grid)
     */
    public function scopeRecent($query)
    {
        return $query->where('is_recent', true);
    }

    /**
     * Scope for ordered list
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->latest();
    }
}
