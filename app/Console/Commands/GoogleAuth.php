<?php

namespace App\Console\Commands;

use App\Services\GoogleReviewsService;
use Illuminate\Console\Command;

class GoogleAuth extends Command
{
    protected $signature = 'google:auth';
    protected $description = 'Interactive OAuth flow to obtain a Google refresh token';

    public function handle(GoogleReviewsService $service): int
    {
        $clientId = config('services.google_business.client_id');
        $clientSecret = config('services.google_business.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            $this->error('GOOGLE_CLIENT_ID and GOOGLE_CLIENT_SECRET must be set in .env before running this command.');
            return self::FAILURE;
        }

        $this->info('=== Google Business Profile OAuth ===');
        $this->newLine();
        $this->line('1. Open the following URL in your browser:');
        $this->newLine();
        $this->line($service->getAuthUrl());
        $this->newLine();
        $this->line('2. Sign in with the Google account that manages your business.');
        $this->line('3. Authorize the application.');
        $this->line('4. You will be redirected to a localhost page that won\'t load — that\'s normal.');
        $this->line('5. Copy the "code" value from the URL bar.');
        $this->line('   Example: http://localhost:8085/oauth/callback?code=4/0ABCDEF...&scope=...');
        $this->line('   Copy only the part after "code=" and before "&scope"');
        $this->newLine();

        $code = $this->ask('Paste the authorization code here');

        if (empty($code)) {
            $this->error('No authorization code provided.');
            return self::FAILURE;
        }

        $code = urldecode(trim($code));

        try {
            $tokens = $service->exchangeCode($code);
        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        $refreshToken = $tokens['refresh_token'] ?? null;

        if (!$refreshToken) {
            $this->error('No refresh token received. Try again with prompt=consent.');
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Success! Add the following to your .env file:');
        $this->newLine();
        $this->line("GOOGLE_REFRESH_TOKEN={$refreshToken}");
        $this->newLine();

        return self::SUCCESS;
    }
}
