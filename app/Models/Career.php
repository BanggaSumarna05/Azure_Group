<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title',
        'department',
        'type',
        'location',
        'description',
        'is_active',
        'deadline',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'deadline' => 'date',
        'published_at' => 'datetime',
    ];

    public function scopeOpen(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
