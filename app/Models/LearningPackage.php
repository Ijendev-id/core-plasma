<?php

namespace App\Models;

use Database\Factories\LearningPackageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'slug',
    'category',
    'question_count',
    'duration_minutes',
    'participants_count',
    'price',
    'leaderboard_price',
    'status',
    'icon',
    'tone',
    'show_participant_preview',
    'published_at',
])]
class LearningPackage extends Model
{
    /** @use HasFactory<LearningPackageFactory> */
    use HasFactory;

    /**
     * Nilai kuota peserta yang berarti "tidak terbatas".
     */
    public const UNLIMITED_QUOTA = 999;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Apakah kuota peserta tryout ini tidak terbatas.
     */
    public function hasUnlimitedQuota(): bool
    {
        return (int) $this->participants_count === self::UNLIMITED_QUOTA;
    }

    /**
     * Jumlah peserta yang sudah terdaftar (enrolled).
     */
    public function enrolledCount(): int
    {
        return $this->members()->count();
    }

    /**
     * Apakah tryout masih menerima pendaftaran (ada slot tersisa).
     */
    public function hasAvailableSlot(): bool
    {
        if ($this->hasUnlimitedQuota()) {
            return true;
        }

        return $this->enrolledCount() < (int) $this->participants_count;
    }

    /**
     * @return BelongsToMany<Member, $this>
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'package_enrollments')
            ->withPivot(['status', 'progress_percent', 'enrolled_at'])
            ->withTimestamps();
    }

    /**
     * @return HasMany<TryoutQuestion, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(TryoutQuestion::class)->orderBy('order_number');
    }

    /**
     * @return HasMany<TryoutAttempt, $this>
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(TryoutAttempt::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'question_count' => 'integer',
            'duration_minutes' => 'integer',
            'participants_count' => 'integer',
            'price' => 'integer',
            'leaderboard_price' => 'integer',
            'show_participant_preview' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
