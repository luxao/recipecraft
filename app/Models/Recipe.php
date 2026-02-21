<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    /** @use HasFactory<\Database\Factories\RecipeFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'servings_default',
        'prep_minutes',
        'cook_minutes',
        'difficulty',
        'visibility',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function ingredients(): HasMany {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function steps(): HasMany {
        return $this->hasMany(RecipeStep::class);
    }

    public function tags(): BelongsToMany {
        return $this->belongsToMany(Tag::class);
    }
}
