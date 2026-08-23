<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'label',
        'type',
    ];

    /**
     * Get setting value by key with optional fallback
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        try {
            $settings = Cache::rememberForever('site_settings_all', function () {
                return self::pluck('value', 'key')->toArray();
            });

            return $settings[$key] ?? $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Set setting value by key
     */
    public static function set(string $key, ?string $value, string $group = 'general', ?string $label = null, string $type = 'text'): self
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'label' => $label,
                'type' => $type,
            ]
        );

        Cache::forget('site_settings_all');

        return $setting;
    }

    /**
     * Clear settings cache on save/delete
     */
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('site_settings_all');
        });

        static::deleted(function () {
            Cache::forget('site_settings_all');
        });
    }
}
