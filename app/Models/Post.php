<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'slug',
        'title_fr',
        'title_nl',
        'excerpt_fr',
        'excerpt_nl',
        'content_fr',
        'content_nl',
        'cover_image',
        'service_id',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->orderByDesc('published_at')
            ->orderByDesc('id');
    }

    /**
     * Champ traduit avec repli sur le français si la version NL est vide.
     */
    public function localized(string $field, ?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();

        return $this->{"{$field}_{$locale}"} ?: $this->{"{$field}_fr"};
    }

    public function coverUrl(): ?string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }

    public function readingMinutes(?string $locale = null): int
    {
        $words = str_word_count(strip_tags($this->localized('content', $locale)));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Résumé : l'extrait saisi, sinon le début du contenu.
     */
    public function summary(?string $locale = null): string
    {
        $excerpt = $this->localized('excerpt', $locale);

        if ($excerpt) {
            return $excerpt;
        }

        $plain = trim(preg_replace('/\s+/', ' ', strip_tags(Str::markdown($this->localized('content', $locale) ?? ''))));

        return Str::limit($plain, 180);
    }

    /**
     * Données pour une carte d'article (liste, accueil, articles liés).
     */
    public function toCard(): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->localized('title'),
            'excerpt' => $this->summary(),
            'cover' => $this->coverUrl(),
            'published_at' => $this->published_at?->toIso8601String(),
            'reading_minutes' => $this->readingMinutes(),
        ];
    }
}
