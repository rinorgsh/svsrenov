<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'client_company',
        'comment_fr',
        'comment_nl',
        'client_photo',
        'rating',
        'is_published',
        'order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'rating' => 'integer',
    ];
}
