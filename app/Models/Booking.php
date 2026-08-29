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
        'delivery_method',
        'delivery_address',
        'delivery_notes',
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
        $prefix = 'TG-' . date('Ym') . '-';
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

    public function tourGuide(): BelongsTo
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function guide(): BelongsTo
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

    public function getLatestPaymentAttribute()
    {
        return $this->payments()->latest()->first();
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Jadwal Terkonfirmasi',
            'in_progress' => 'Tur Sedang Berlangsung',
            'qc' => 'Dokumentasi & Review Tur',
            'completed' => 'Tur Selesai Sukses',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'Lunas Penuh',
            'dp_paid' => 'DP Terbayar (Booking Locked)',
            'refunded' => 'Dana Dikembalikan (Refund)',
            default => 'Belum Bayar',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300 dark:bg-amber-950 dark:text-amber-300 dark:border-amber-800">Menunggu Konfirmasi</span>',
            'confirmed' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800 border border-blue-300 dark:bg-blue-950 dark:text-blue-300 dark:border-blue-800">Jadwal Terkonfirmasi</span>',
            'in_progress' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-emerald-950 dark:text-emerald-300 dark:border-emerald-800 animate-pulse">Tur Berlangsung</span>',
            'qc' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-teal-100 text-teal-800 border border-teal-300 dark:bg-teal-950 dark:text-teal-300 dark:border-teal-800">Dokumentasi & Review</span>',
            'completed' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-800 border border-green-300 dark:bg-green-950 dark:text-green-300 dark:border-green-800">Tur Selesai</span>',
            'cancelled' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-800 border border-red-300 dark:bg-red-950 dark:text-red-300 dark:border-red-800">Dibatalkan</span>',
            default => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-neutral-100 text-neutral-800 border border-neutral-300 dark:bg-neutral-800 dark:text-neutral-300 dark:border-neutral-700">' . ucfirst($this->status) . '</span>',
        };
    }

    public function getPaymentBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-emerald-950 dark:text-emerald-300 dark:border-emerald-800">Lunas Penuh</span>',
            'dp_paid' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-teal-100 text-teal-800 border border-teal-300 dark:bg-teal-950 dark:text-teal-300 dark:border-teal-800">DP Terbayar</span>',
            'refunded' => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-purple-100 text-purple-800 border border-purple-300 dark:bg-purple-950 dark:text-purple-300 dark:border-purple-800">Refund</span>',
            default => '<span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-300 dark:bg-amber-950 dark:text-amber-300 dark:border-amber-800">Belum Bayar</span>',
        };
    }

    public function getVehicleTypeLabelAttribute(): string
    {
        return match ($this->vehicle_type) {
            'private' => 'Private Guided Tour',
            'group' => 'Open Trip / Group Tour',
            'family' => 'Family & Custom Expedition',
            'motor' => 'Adventure Trip',
            'mobil' => 'Comfort Tour',
            default => 'Private Guided Tour',
        };
    }

    /**
     * Warranty duration in days based on service type.
     */
    public function getWarrantyDaysAttribute(): int
    {
        if ($this->service) {
            $slug = strtolower($this->service->slug ?? '');
            if (str_contains($slug, 'build') || str_contains($slug, 'restoration') || str_contains($slug, 'body') || str_contains($slug, 'paint')) {
                return 180; // 6 months warranty
            }
            if (str_contains($slug, 'ecu') || str_contains($slug, 'tuning') || str_contains($slug, 'engine') || str_contains($slug, 'turbo') || str_contains($slug, 'exhaust')) {
                return 90; // 3 months warranty
            }
        }
        return 30; // Standard 30 days warranty
    }

    /**
     * Warranty start date (when status is completed).
     */
    public function getWarrantyStartDateAttribute(): ?\Illuminate\Support\Carbon
    {
        return $this->updated_at ?? $this->created_at;
    }

    /**
     * Warranty end date.
     */
    public function getWarrantyEndDateAttribute(): ?\Illuminate\Support\Carbon
    {
        $start = $this->warranty_start_date;
        return $start ? $start->copy()->addDays($this->warranty_days) : null;
    }

    /**
     * Check if warranty is currently active.
     */
    public function getIsWarrantyActiveAttribute(): bool
    {
        if ($this->status !== 'completed') {
            return false;
        }

        $end = $this->warranty_end_date;
        return $end ? now()->lte($end) : false;
    }

    /**
     * Number of days remaining for warranty.
     */
    public function getWarrantyRemainingDaysAttribute(): int
    {
        if (!$this->is_warranty_active) {
            return 0;
        }

        $end = $this->warranty_end_date;
        return $end ? max(0, (int) now()->diffInDays($end, false)) : 0;
    }

    /**
     * Warranty status badge.
     */
    public function getWarrantyStatusBadgeAttribute(): string
    {
        if ($this->status !== 'completed') {
            return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-600 border border-neutral-200">Menunggu Pengerjaan Selesai</span>';
        }

        if ($this->is_warranty_active) {
            $days = $this->warranty_remaining_days;
            if ($days <= 7) {
                return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/20 text-amber-600 border border-amber-500/30">Garansi Aktif (' . $days . ' Hari Lagi)</span>';
            }
            return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-600 border border-emerald-500/30">✓ Garansi Aktif (' . $days . ' Hari)</span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-600 border border-red-500/30">Masa Garansi Berakhir</span>';
    }

    /**
     * Sisa tagihan pelunasan (Total - Paid).
     */
    public function getRemainingAmountAttribute(): float
    {
        $total = (float) ($this->total_amount > 0 ? $this->total_amount : ($this->service->price ?? 0));
        $paid = (float) $this->paid_amount;
        return max(0, $total - $paid);
    }

    public function getFormattedRemainingAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->remaining_amount, 0, ',', '.');
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->payment_status === 'paid' || ($this->remaining_amount <= 0 && $this->paid_amount > 0);
    }

    public function getDeliveryMethodLabelAttribute(): string
    {
        return match ($this->delivery_method) {
            'delivery_address' => 'Diantar ke Alamat Customer (Delivery / Towing)',
            default => 'Selesai di Titik Kumpul / Hotel',
        };
    }
}

