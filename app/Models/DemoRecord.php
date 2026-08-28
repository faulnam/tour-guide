<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemoRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type',
        'record_id',
        'user_id',
        'action',
        'original_data',
        'file_paths',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'original_data' => 'array',
            'file_paths' => 'array',
            'expires_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
