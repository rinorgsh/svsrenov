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

    /**
     * Texte de l'avis sans la traduction automatique ajoutée par Google.
     * « texte original (Translated by Google) traduction » => texte original
     * « (Translated by Google) traduction (Original) texte » => texte
     */
    public static function cleanComment(?string $comment): ?string
    {
        if (! $comment) {
            return $comment;
        }

        if (preg_match('/\(Original\)\s*(.+)$/s', $comment, $m)) {
            $comment = $m[1];
        } else {
            $comment = preg_split('/\(Translated by Google\)/', $comment)[0];
        }

        return trim($comment, " \n\r\t\"“”") ?: null;
    }
}
