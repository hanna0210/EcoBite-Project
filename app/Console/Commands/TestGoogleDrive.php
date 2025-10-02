<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestGoogleDrive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:google-drive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Google Drive filesystem configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing Google Drive configuration...');

        try {
            // Test if the disk is configured
            $disk = Storage::disk('gdrive');
            $this->info('✓ Google Drive disk is configured');

            // Test basic operations (these will fail without proper credentials)
            $testFile = 'test-' . time() . '.txt';
            $testContent = 'This is a test file for Google Drive integration.';

            $this->info('Attempting to write test file...');
            $disk->put($testFile, $testContent);
            $this->info('✓ Test file written successfully');

            $this->info('Attempting to read test file...');
            $content = $disk->get($testFile);
            $this->info('✓ Test file read successfully');

            $this->info('Attempting to delete test file...');
            $disk->delete($testFile);
            $this->info('✓ Test file deleted successfully');

            $this->info('🎉 Google Drive integration is working correctly!');

        } catch (\Exception $e) {
            $this->error('❌ Google Drive test failed: ' . $e->getMessage());
            $this->info('');
            $this->info('Please check:');
            $this->info('1. Google Drive credentials in .env file');
            $this->info('2. Google Cloud Console configuration');
            $this->info('3. OAuth 2.0 setup');
            return 1;
        }

        return 0;
    }
}
