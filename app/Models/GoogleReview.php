<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    protected $fillable = [
        'google_review_id',
        'author_name',
        'author_photo_url',
        'rating',
        'comment',
        'relative_time',
        'published_at',
        'is_visible',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_visible' => 'boolean',
        'published_at' => 'datetime',
    ];
}
