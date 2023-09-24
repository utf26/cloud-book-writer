<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->whereNull('parent_id')->with('subsections');
    }

    public function sectionsWithoutSubsections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role_id')->withTimestamps();
    }
}
