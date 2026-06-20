<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'member_id',
    'learning_package_id',
    'score',
    'twk_score',
    'tiu_score',
    'tkp_score',
    'answered_count',
    'correct_count',
    'duration_seconds',
    'status',
    'started_at',
    'finished_at',
    'certificate_printed_at',
])]
class TryoutAttempt extends Model
{
    /**
     * @return BelongsTo<Member, $this>
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * @return BelongsTo<LearningPackage, $this>
     */
    public function learningPackage(): BelongsTo
    {
        return $this->belongsTo(LearningPackage::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'score' => 'integer',
            'twk_score' => 'integer',
            'tiu_score' => 'integer',
            'tkp_score' => 'integer',
            'answered_count' => 'integer',
            'correct_count' => 'integer',
            'duration_seconds' => 'integer',
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'certificate_printed_at' => 'datetime',
        ];
    }
}
