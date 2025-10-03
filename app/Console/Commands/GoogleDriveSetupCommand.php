<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GoogleDriveSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gdrive:setup {--test : Test the Google Drive connection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup and test Google Drive integration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('test')) {
            return $this->testConnection();
        }

        $this->info('Google Drive Setup Helper');
        $this->line('');

        // Check environment variables
        $this->checkEnvironmentVariables();

        // Show setup instructions
        $this->showSetupInstructions();

        // Ask if user wants to test
        if ($this->confirm('Would you like to test the Google Drive connection now?')) {
            $this->testConnection();
        }
    }

    private function checkEnvironmentVariables()
    {
        $this->info('Checking environment variables...');
        
        $required = [
            'GOOGLE_DRIVE_CLIENT_ID' => env('GOOGLE_DRIVE_CLIENT_ID'),
            'GOOGLE_DRIVE_CLIENT_SECRET' => env('GOOGLE_DRIVE_CLIENT_SECRET'),
            'GOOGLE_DRIVE_REFRESH_TOKEN' => env('GOOGLE_DRIVE_REFRESH_TOKEN'),
            'GOOGLE_DRIVE_FOLDER_ID' => env('GOOGLE_DRIVE_FOLDER_ID'),
        ];

        $allSet = true;
        foreach ($required as $key => $value) {
            if (empty($value)) {
                $this->error("❌ {$key} is not set");
                $allSet = false;
            } else {
                $this->info("✅ {$key} is set");
            }
        }

        if (!$allSet) {
            $this->line('');
            $this->warn('Some environment variables are missing. Please set them in your .env file.');
            $this->line('');
        }

        return $allSet;
    }

    private function showSetupInstructions()
    {
        $this->info('Setup Instructions:');
        $this->line('');
        $this->line('1. Go to Google Cloud Console: https://console.cloud.google.com/');
        $this->line('2. Enable Google Drive API');
        $this->line('3. Create OAuth 2.0 credentials');
        $this->line('4. Get refresh token from OAuth Playground: https://developers.google.com/oauthplayground');
        $this->line('5. Add credentials to your .env file');
        $this->line('6. Run: php artisan gdrive:setup --test');
        $this->line('');
        $this->line('For detailed instructions, see: GOOGLE_DRIVE_SETUP.md');
        $this->line('');
    }

    private function testConnection()
    {
        $this->info('Testing Google Drive connection...');
        
        try {
            // Test if we can access the disk
            $disk = Storage::disk('gdrive');
            $this->info('✅ Google Drive disk is accessible');
            
            // Test file upload
            $testContent = 'Test file created at ' . now();
            $testPath = 'test-connection-' . time() . '.txt';
            
            $disk->put($testPath, $testContent);
            $this->info('✅ File upload successful');
            
            // Test file read
            $readContent = $disk->get($testPath);
            if ($readContent === $testContent) {
                $this->info('✅ File read successful');
            } else {
                $this->error('❌ File read failed - content mismatch');
            }
            
            // Test file deletion
            $disk->delete($testPath);
            $this->info('✅ File deletion successful');
            
            $this->line('');
            $this->info('🎉 Google Drive integration is working correctly!');
            
        } catch (\Exception $e) {
            $this->error('❌ Google Drive connection failed: ' . $e->getMessage());
            $this->line('');
            $this->warn('Please check your credentials and try again.');
            $this->line('Run: php artisan gdrive:setup for setup instructions.');
        }
    }
}
