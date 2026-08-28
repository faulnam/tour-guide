<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'brand',
        'model',
        'license_plate',
        'year',
        'color',
        'engine_cc',
        'transmission',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayNameAttribute(): string
    {
        $icon = $this->type === 'motor' ? '🏍️' : '🚗';
        return "{$icon} {$this->brand} {$this->model} ({$this->license_plate})";
    }
}
