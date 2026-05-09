<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'member_id',
    'learning_package_id',
    'status',
    'progress_percent',
    'enrolled_at',
])]
class PackageEnrollment extends Model
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
            'progress_percent' => 'integer',
            'enrolled_at' => 'datetime',
        ];
    }
}
