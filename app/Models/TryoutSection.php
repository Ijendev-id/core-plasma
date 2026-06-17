<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'tryout_category_id',
    'code',
    'name',
])]
class TryoutSection extends Model
{
    /**
     * @return BelongsTo<TryoutCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TryoutCategory::class, 'tryout_category_id');
    }
}
