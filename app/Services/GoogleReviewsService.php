<?php

namespace App\Services;

use App\Models\GoogleReview;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleReviewsService
{
    protected array $config;

    public function __construct()
    {
        $this->config = config('services.google_business');
    }

    /**
     * Check if all required Google Business credentials are configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->config['client_id'])
            && !empty($this->config['client_secret'])
            && !empty($this->config['refresh_token'])
            && !empty($this->config['account_id'])
            && !empty($this->config['location_id']);
    }

    /**
     * Generate OAuth URL for initial authentication.
     */
    public function getAuthUrl(): string
    {
        $params = http_build_query([
            'client_id' => $this->config['client_id'],
            'redirect_uri' => 'http://localhost:8085/oauth/callback',
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/business.manage',
            'access_type' => 'offline',
            'prompt' => 'consent',
        ]);

        return "https://accounts.google.com/o/oauth2/v2/auth?{$params}";
    }

    /**
     * Exchange authorization code for tokens.
     */
    public function exchangeCode(string $code): array
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => 'http://localhost:8085/oauth/callback',
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to exchange code: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Get a fresh access token using the refresh token.
     */
    protected function getAccessToken(): string
    {
        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'refresh_token' => $this->config['refresh_token'],
            'grant_type' => 'refresh_token',
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to refresh access token: ' . $response->body());
        }

        return $response->json('access_token');
    }

    /**
     * Fetch all reviews from Google Business Profile API (paginated).
     */
    public function fetchAllReviews(): array
    {
        $accessToken = $this->getAccessToken();
        $accountId = $this->config['account_id'];
        $locationId = $this->config['location_id'];

        $allReviews = [];
        $pageToken = null;

        do {
            $url = "https://mybusiness.googleapis.com/v4/accounts/{$accountId}/locations/{$locationId}/reviews";

            $query = ['pageSize' => 50];
            if ($pageToken) {
                $query['pageToken'] = $pageToken;
            }

            $response = Http::withToken($accessToken)->get($url, $query);

            if ($response->failed()) {
                throw new \RuntimeException('Failed to fetch reviews: ' . $response->body());
            }

            $data = $response->json();
            $reviews = $data['reviews'] ?? [];
            $allReviews = array_merge($allReviews, $reviews);
            $pageToken = $data['nextPageToken'] ?? null;
        } while ($pageToken);

        return $allReviews;
    }

    /**
     * Convert Google star rating enum to integer.
     */
    public function mapStarRating(string $starRating): int
    {
        return match ($starRating) {
            'ONE' => 1,
            'TWO' => 2,
            'THREE' => 3,
            'FOUR' => 4,
            'FIVE' => 5,
            default => 0,
        };
    }

    /**
     * Sync reviews from Google API to local database.
     */
    public function syncReviews(): array
    {
        $reviews = $this->fetchAllReviews();

        $created = 0;
        $updated = 0;

        foreach ($reviews as $review) {
            $googleReviewId = $review['reviewId'] ?? null;
            if (!$googleReviewId) {
                continue;
            }

            $data = [
                'author_name' => $review['reviewer']['displayName'] ?? 'Anonymous',
                'author_photo_url' => $review['reviewer']['profilePhotoUrl'] ?? null,
                'rating' => $this->mapStarRating($review['starRating'] ?? ''),
                'comment' => $review['comment'] ?? null,
                'relative_time' => $review['relativeTimeDescription'] ?? null,
                'published_at' => isset($review['createTime']) ? \Carbon\Carbon::parse($review['createTime']) : null,
            ];

            $existing = GoogleReview::where('google_review_id', $googleReviewId)->first();

            if ($existing) {
                $existing->update($data);
                $updated++;
            } else {
                GoogleReview::create(array_merge($data, ['google_review_id' => $googleReviewId]));
                $created++;
            }
        }

        return [
            'total' => count($reviews),
            'created' => $created,
            'updated' => $updated,
        ];
    }
}
