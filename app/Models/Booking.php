<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'customer_id',
        'karyawan_id',
        'service_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'vehicle_type',
        'vehicle_brand',
        'vehicle_model',
        'license_plate',
        'vehicle_year',
        'vehicle_color',
        'booking_date',
        'booking_time_slot',
        'custom_request',
        'mechanic_notes',
        'progress_percentage',
        'status',
        'total_amount',
        'dp_amount',
        'paid_amount',
        'payment_status',
        'payment_method',
        'payment_token',
        'payment_ref',
        'payment_payload',
        'progress_photos',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'progress_percentage' => 'integer',
            'total_amount' => 'decimal:2',
            'dp_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'progress_photos' => 'array',
        ];
    }

    public static function generateBookingCode(): string
    {
        $prefix = 'BK-' . date('Ym') . '-';
        $count = self::whereYear('created_at', date('Y'))
                     ->whereMonth('created_at', date('m'))
                     ->count() + 1;
        return $prefix . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function mechanic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'booking_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BookingLog::class, 'booking_id')->latest();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">Menunggu Konfirmasi</span>',
            'confirmed' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-400 border border-blue-500/30">Terkonfirmasi</span>',
            'in_progress' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-400 border border-purple-500/30 animate-pulse">Sedang Dikerjakan</span>',
            'qc' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-500/20 text-cyan-400 border border-cyan-500/30">Quality Control & Dyno</span>',
            'completed' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Selesai / Siap Diambil</span>',
            'cancelled' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-400 border border-red-500/30">Dibatalkan</span>',
            default => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-neutral-700 text-neutral-300">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Lunas</span>',
            'dp_paid' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-500/20 text-cyan-400 border border-cyan-500/30">DP Terbayar</span>',
            'refunded' => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-400 border border-purple-500/30">Refund</span>',
            default => '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30">Belum Bayar</span>',
        };
    }

    public function getVehicleTypeLabelAttribute(): string
    {
        return $this->vehicle_type === 'motor' ? '🏍️ Motor' : '🚗 Mobil';
    }
}
