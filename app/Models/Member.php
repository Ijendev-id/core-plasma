<?php

namespace App\Models;

use Database\Factories\MemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable([
    'uuid',
    'name',
    'email',
    'password',
    'remember_token',
    'photo_profile',
    'pendidikan_terakhir',
])]
#[Hidden(['password', 'remember_token'])]
class Member extends Authenticatable
{
    /** @use HasFactory<MemberFactory> */
    use HasFactory, SoftDeletes;

    /**
     * @return BelongsToMany<LearningPackage, $this>
     */
    public function learningPackages(): BelongsToMany
    {
        return $this->belongsToMany(LearningPackage::class, 'package_enrollments')
            ->withPivot(['status', 'progress_percent', 'enrolled_at'])
            ->withTimestamps();
    }

    /**
     * @return HasMany<TryoutAttempt, $this>
     */
    public function tryoutAttempts(): HasMany
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
            'password' => 'hashed',
        ];
    }
}
