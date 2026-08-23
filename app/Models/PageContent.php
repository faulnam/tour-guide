<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'page',
        'section',
        'label',
    ];

    /**
     * Get content value by key with optional fallback
     */
    public static function get(string $key, ?string $default = null): ?string
    {
        try {
            $contents = Cache::rememberForever('page_contents_all', function () {
                return self::pluck('value', 'key')->toArray();
            });

            return $contents[$key] ?? $default;
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * Set content value by key
     */
    public static function set(string $key, ?string $value, string $page = 'home', string $section = 'general', ?string $label = null): self
    {
        $content = self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'page' => $page,
                'section' => $section,
                'label' => $label,
            ]
        );

        Cache::forget('page_contents_all');

        return $content;
    }

    /**
     * Clear page contents cache on save/delete
     */
    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('page_contents_all');
        });

        static::deleted(function () {
            Cache::forget('page_contents_all');
        });
    }
}
