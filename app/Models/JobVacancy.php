<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'responsibilities',
        'requirements',
        'email_subject',
        'is_active',
        'posted_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'posted_at' => 'date',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_vacancy_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
