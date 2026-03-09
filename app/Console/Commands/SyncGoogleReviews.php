<?php

namespace App\Console\Commands;

use App\Services\GoogleReviewsService;
use Illuminate\Console\Command;

class SyncGoogleReviews extends Command
{
    protected $signature = 'google:sync-reviews';
    protected $description = 'Sync Google Business Profile reviews to local database';

    public function handle(GoogleReviewsService $service): int
    {
        if (!$service->isConfigured()) {
            $this->warn('Google Business Profile is not fully configured. Please check your .env file.');
            $this->line('Required: GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REFRESH_TOKEN, GOOGLE_ACCOUNT_ID, GOOGLE_LOCATION_ID');
            return self::SUCCESS;
        }

        $this->info('Syncing Google reviews...');

        try {
            $stats = $service->syncReviews();

            $this->info("Done! Total: {$stats['total']}, Created: {$stats['created']}, Updated: {$stats['updated']}");

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to sync reviews: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
