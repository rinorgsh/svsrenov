<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'slug',
        'icon',
        'title_fr',
        'title_nl',
        'description_fr',
        'description_nl',
        'long_description_fr',
        'long_description_nl',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function contactRequests()
    {
        return $this->hasMany(ContactRequest::class);
    }
}
