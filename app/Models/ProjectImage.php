<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'path',
        'caption_fr',
        'caption_nl',
        'order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
