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

    public function getClockInAttribute(): ?string
    {
        return $this->check_in_time ? substr($this->check_in_time, 0, 5) : null;
    }

    public function getClockOutAttribute(): ?string
    {
        return $this->check_out_time ? substr($this->check_out_time, 0, 5) : null;
    }

    public function getPhotoInAttribute(): ?string
    {
        return $this->check_in_photo;
    }

    public function getPhotoOutAttribute(): ?string
    {
        return $this->check_out_photo;
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
            'hadir', 'present' => '<span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-bold bg-neutral-100 text-black border border-neutral-300">Hadir Tepat Waktu</span>',
            'terlambat', 'late' => '<span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-bold bg-neutral-100 text-neutral-700 border border-neutral-300">Terlambat</span>',
            'izin' => '<span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-bold bg-neutral-100 text-neutral-700 border border-neutral-300">Izin</span>',
            'sakit' => '<span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-bold bg-neutral-100 text-neutral-700 border border-neutral-300">Sakit</span>',
            default => '<span class="inline-flex items-center px-2 py-0.5 text-[10px] uppercase font-bold bg-neutral-100 text-neutral-700 border border-neutral-300">Alpa</span>',
        };
    }
}
