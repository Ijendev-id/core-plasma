<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
])]
class TryoutCategory extends Model
{
    /**
     * @return HasMany<TryoutSection, $this>
     */
    public function sections(): HasMany
    {
        return $this->hasMany(TryoutSection::class, 'tryout_category_id')->orderBy('code');
    }
}
