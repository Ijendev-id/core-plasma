<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'learning_package_id',
    'section',
    'prompt',
    'attachment_path',
    'order_number',
    'points',
    'is_active',
])]
class TryoutQuestion extends Model
{
    /**
     * @return BelongsTo<LearningPackage, $this>
     */
    public function learningPackage(): BelongsTo
    {
        return $this->belongsTo(LearningPackage::class);
    }

    /**
     * @return HasMany<TryoutAnswer, $this>
     */
    public function answers(): HasMany
    {
        return $this->hasMany(TryoutAnswer::class)->orderBy('label');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'order_number' => 'integer',
            'points' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
