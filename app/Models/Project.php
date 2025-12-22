<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'service_id',
        'title_fr',
        'title_nl',
        'description_fr',
        'description_nl',
        'location',
        'image_before',
        'image_after',
        'completion_date',
        'is_featured',
        'is_published',
        'order',
    ];

    protected $casts = [
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
