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
        'vehicle_type',
        'vehicle_model',
        'client',
        'location',
        'year',
        'description',
        'cover_image',
        'before_image',
        'after_image',
        'dyno_hp_before',
        'dyno_hp_after',
        'dyno_torque_before',
        'dyno_torque_after',
        'modification_specs',
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
            'dyno_hp_before' => 'integer',
            'dyno_hp_after' => 'integer',
            'dyno_torque_before' => 'integer',
            'dyno_torque_after' => 'integer',
            'modification_specs' => 'array',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class, 'project_id')->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query)
    {
        return $query->where('is_recent', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->latest();
    }

    public function getHpGainAttribute(): ?int
    {
        if ($this->dyno_hp_before && $this->dyno_hp_after) {
            return $this->dyno_hp_after - $this->dyno_hp_before;
        }
        return null;
    }

    public function getTorqueGainAttribute(): ?int
    {
        if ($this->dyno_torque_before && $this->dyno_torque_after) {
            return $this->dyno_torque_after - $this->dyno_torque_before;
        }
        return null;
    }
}
