<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'tryout_question_id',
    'label',
    'answer_text',
    'is_correct',
])]
class TryoutAnswer extends Model
{
    /**
     * @return BelongsTo<TryoutQuestion, $this>
     */
    public function tryoutQuestion(): BelongsTo
    {
        return $this->belongsTo(TryoutQuestion::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }
}
