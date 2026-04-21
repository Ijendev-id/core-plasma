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
    'participants_count',
    'price',
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

    public function getRouteKeyName(): string
    {
        return 'slug';
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
            'participants_count' => 'integer',
            'price' => 'integer',
            'show_participant_preview' => 'boolean',
            'published_at' => 'datetime',
        ];
    }
}
