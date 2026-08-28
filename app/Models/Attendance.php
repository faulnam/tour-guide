<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'check_in_time',
        'check_in_photo',
        'check_in_lat',
        'check_in_lng',
        'check_out_time',
        'check_out_photo',
        'check_out_lat',
        'check_out_lng',
        'status',
        'work_summary',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'check_in_lat' => 'decimal:8',
            'check_in_lng' => 'decimal:8',
            'check_out_lat' => 'decimal:8',
            'check_out_lng' => 'decimal:8',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCheckInPhotoUrlAttribute(): ?string
    {
        if (!$this->check_in_photo) {
            return null;
        }
        if (str_starts_with($this->check_in_photo, 'http') || str_starts_with($this->check_in_photo, 'data:image')) {
            return $this->check_in_photo;
        }
        return asset('storage/' . $this->check_in_photo);
    }

    public function getCheckOutPhotoUrlAttribute(): ?string
    {
        if (!$this->check_out_photo) {
            return null;
        }
        if (str_starts_with($this->check_out_photo, 'http') || str_starts_with($this->check_out_photo, 'data:image')) {
            return $this->check_out_photo;
        }
        return asset('storage/' . $this->check_out_photo);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'hadir' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-900/40 text-emerald-400 border border-emerald-700">Hadir Tepat Waktu</span>',
            'terlambat' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-900/40 text-amber-400 border border-amber-700">Terlambat</span>',
            'izin' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-900/40 text-blue-400 border border-blue-700">Izin</span>',
            'sakit' => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-900/40 text-purple-400 border border-purple-700">Sakit</span>',
            default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900/40 text-red-400 border border-red-700">Alpa</span>',
        };
    }
}
