<?php

namespace App\Http\Livewire\Settings;

use Exception;
use GeoSot\EnvEditor\Facades\EnvEditor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StorageSettings extends BaseSettingsComponent
{
    // Storage disk selection
    public $mediaDisk;
    public $storageDiskOptions = [];
    
    // Google Drive credentials
    public $googleDriveClientId;
    public $googleDriveClientSecret;
    public $googleDriveRefreshToken;
    public $googleDriveFolderId;
    
    // Connection status
    public $connectionStatus = '';
    public $connectionMessage = '';
    public $showConnectionTest = false;

    public function mount()
    {
        $this->loadStorageSettings();
        $this->storageDiskOptions = [
            ['id' => 'public', 'name' => 'Local Storage (Public)'],
            ['id' => 'local', 'name' => 'Local Storage (Private)'],
            ['id' => 'gdrive', 'name' => 'Google Drive'],
        ];
    }

    public function render()
    {
        return view('livewire.settings.storage-settings');
    }

    public function loadStorageSettings()
    {
        // Load current storage disk
        $this->mediaDisk = env('MEDIA_DISK', 'public');
        
        // Load Google Drive credentials
        $this->googleDriveClientId = env('GOOGLE_DRIVE_CLIENT_ID', '');
        $this->googleDriveClientSecret = env('GOOGLE_DRIVE_CLIENT_SECRET', '');
        $this->googleDriveRefreshToken = env('GOOGLE_DRIVE_REFRESH_TOKEN', '');
        $this->googleDriveFolderId = env('GOOGLE_DRIVE_FOLDER_ID', '');
    }

    public function saveStorageSettings()
    {
        try {
            $this->isDemo();

            // Validate Google Drive credentials if gdrive is selected
            if ($this->mediaDisk === 'gdrive') {
                $this->validate([
                    'googleDriveClientId' => 'required|string',
                    'googleDriveClientSecret' => 'required|string',
                    'googleDriveRefreshToken' => 'required|string',
                ]);
            }

            // Update .env file
            $envData = [
                'MEDIA_DISK' => $this->mediaDisk,
            ];

            // Only update Google Drive credentials if they're provided
            if (!empty($this->googleDriveClientId)) {
                $envData['GOOGLE_DRIVE_CLIENT_ID'] = $this->googleDriveClientId;
            }
            if (!empty($this->googleDriveClientSecret)) {
                $envData['GOOGLE_DRIVE_CLIENT_SECRET'] = $this->googleDriveClientSecret;
            }
            if (!empty($this->googleDriveRefreshToken)) {
                $envData['GOOGLE_DRIVE_REFRESH_TOKEN'] = $this->googleDriveRefreshToken;
            }
            if (!empty($this->googleDriveFolderId)) {
                $envData['GOOGLE_DRIVE_FOLDER_ID'] = $this->googleDriveFolderId;
            }

            // Save to .env file
            foreach ($envData as $key => $value) {
                EnvEditor::editKey($key, $value);
            }

            $this->showSuccessAlert(__("Storage settings saved successfully!"));
            $this->showConnectionTest = false;
            
        } catch (Exception $error) {
            $this->showErrorAlert($error->getMessage() ?? __("Failed to save storage settings!"));
        }
    }

    public function testGoogleDriveConnection()
    {
        $this->connectionStatus = '';
        $this->connectionMessage = '';
        
        try {
            // Check if credentials are provided
            if (empty($this->googleDriveClientId) || empty($this->googleDriveClientSecret) || empty($this->googleDriveRefreshToken)) {
                $this->connectionStatus = 'error';
                $this->connectionMessage = __('Please provide all Google Drive credentials before testing.');
                $this->showConnectionTest = true;
                return;
            }

            // Temporarily set credentials for testing (without saving)
            config([
                'filesystems.disks.gdrive.clientId' => $this->googleDriveClientId,
                'filesystems.disks.gdrive.clientSecret' => $this->googleDriveClientSecret,
                'filesystems.disks.gdrive.refreshToken' => $this->googleDriveRefreshToken,
                'filesystems.disks.gdrive.folderId' => $this->googleDriveFolderId,
            ]);

            // Clear any cached filesystem instances
            app('filesystem')->forgetDisk('gdrive');

            // Test connection by trying to access the disk
            $disk = Storage::disk('gdrive');
            
            // Try to create a test file
            $testContent = 'Test file created at ' . now();
            $testPath = 'test-connection-' . time() . '.txt';
            
            $disk->put($testPath, $testContent);
            
            // Try to read it back
            $readContent = $disk->get($testPath);
            
            // Clean up test file
            $disk->delete($testPath);
            
            if ($readContent === $testContent) {
                $this->connectionStatus = 'success';
                $this->connectionMessage = __('Google Drive connection successful! ✓');
            } else {
                $this->connectionStatus = 'error';
                $this->connectionMessage = __('Google Drive connection test failed - content mismatch.');
            }
            
        } catch (Exception $e) {
            $this->connectionStatus = 'error';
            $this->connectionMessage = __('Connection failed: ') . $e->getMessage();
            
            Log::error('Google Drive connection test failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        $this->showConnectionTest = true;
    }

    public function updatedMediaDisk($value)
    {
        // Reset connection test when disk changes
        $this->showConnectionTest = false;
        $this->connectionStatus = '';
        $this->connectionMessage = '';
    }
}

