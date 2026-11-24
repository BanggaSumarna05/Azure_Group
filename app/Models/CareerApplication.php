<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    protected $fillable = [
        'career_id',
        'name',
        'email',
        'phone',
        'message',
        'cv_path',
        'status',
        'notes',
    ];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new'         => 'New',
            'reviewed'    => 'Reviewed',
            'shortlisted' => 'Shortlisted',
            'rejected'    => 'Rejected',
            default       => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'new'         => 'info',
            'reviewed'    => 'warning',
            'shortlisted' => 'success',
            'rejected'    => 'danger',
            default       => 'gray',
        };
    }
}
