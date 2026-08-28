<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'specialty',
        'avatar',
        'address',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Check if user is super admin or admin
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isSuperAdmin(): bool
    {
        return in_array($this->role, ['admin', 'super_admin']);
    }

    public function isEditor(): bool
    {
        return in_array($this->role, ['admin', 'super_admin', 'editor']);
    }

    /**
     * Check if user is karyawan (mechanic/technician/staff)
     */
    public function isKaryawan(): bool
    {
        return $this->role === 'karyawan';
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Relasi ke absensi (untuk karyawan)
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    /**
     * Relasi ke booking yang ditugaskan (sebagai mekanik)
     */
    public function assignedBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'karyawan_id');
    }

    /**
     * Relasi ke booking pelanggan (sebagai customer)
     */
    public function customerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    /**
     * Relasi ke garasi kendaraan (sebagai customer)
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    /**
     * Relasi ke riwayat transaksi pembayaran
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'user_id');
    }
}
