<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Tag::class, 'tag_id');
    }
}
