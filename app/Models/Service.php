<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'vehicle_type',
        'category',
        'excerpt',
        'description',
        'base_price',
        'estimated_duration',
        'warranty',
        'features',
        'icon',
        'image',
        'order',
        'is_popular',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'features' => 'array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Service::class, 'parent_id')->orderBy('order')->orderBy('title');
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'service_id')->orderBy('order')->latest();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('title');
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->base_price > 0 
            ? 'Rp ' . number_format($this->base_price, 0, ',', '.') 
            : 'Hubungi Kami / Estimasi';
    }

    public function getVehicleBadgeAttribute(): string
    {
        return match ($this->vehicle_type) {
            'motor' => '<span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-amber-500/20 text-amber-400 border border-amber-500/30">Motor</span>',
            'mobil' => '<span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-blue-500/20 text-blue-400 border border-blue-500/30">Mobil</span>',
            default => '<span class="px-2 py-0.5 rounded text-[10px] uppercase font-bold bg-purple-500/20 text-purple-400 border border-purple-500/30">Motor & Mobil</span>',
        };
    }
}
