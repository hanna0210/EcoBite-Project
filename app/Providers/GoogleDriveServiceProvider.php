<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemAdapter as LaravelFilesystemAdapter;
use Google\Client;
use Google\Service\Drive;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\Config;
use League\Flysystem\FileAttributes;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            // Check if Google Drive credentials are configured
            if (empty($config['clientId']) || empty($config['clientSecret']) || empty($config['refreshToken'])) {
                // Return a dummy filesystem that throws helpful errors
                $dummyAdapter = new class implements FilesystemAdapter {
                    public function fileExists(string $path): bool {
                        return false;
                    }
                    
                    public function directoryExists(string $path): bool {
                        return false;
                    }
                    
                    public function write(string $path, string $contents, Config $config): void {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function writeStream(string $path, $contents, Config $config): void {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function read(string $path): string {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function readStream(string $path) {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function delete(string $path): void {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function deleteDirectory(string $path): void {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function createDirectory(string $path, Config $config): void {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function setVisibility(string $path, string $visibility): void {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function visibility(string $path): FileAttributes {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function mimeType(string $path): FileAttributes {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function lastModified(string $path): FileAttributes {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function fileSize(string $path): FileAttributes {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function listContents(string $path, bool $deep): iterable {
                        return [];
                    }
                    
                    public function move(string $source, string $destination, Config $config): void {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                    
                    public function copy(string $source, string $destination, Config $config): void {
                        throw new \Exception('Google Drive credentials not configured.');
                    }
                };
                
                $dummyFilesystem = new Filesystem($dummyAdapter, $config);
                
                // Return FilesystemAdapter with url method override
                return new class($dummyFilesystem, $dummyAdapter, $config) extends LaravelFilesystemAdapter {
                    public function url($path)
                    {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                };
            }

            $client = new Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->setAccessType('offline');
            $client->setApprovalPrompt('force');
            
            // Get access token from refresh token
            $client->refreshToken($config['refreshToken']);
            $accessToken = $client->getAccessToken();
            
            if (!$accessToken) {
                throw new \Exception('Failed to get access token from refresh token. Please check your credentials.');
            }
            
            $client->setAccessToken($accessToken);
            $service = new Drive($client);
            
            // Create a simple adapter that implements the basic filesystem interface
            $adapter = new class($service, $config['folderId']) implements \League\Flysystem\FilesystemAdapter {
                private $service;
                private $folderId;
                private $fileCache = [];
                
                public function __construct($service, $folderId) {
                    $this->service = $service;
                    $this->folderId = $folderId;
                }
                
                public function fileExists(string $path): bool {
                    return $this->getFileId($path) !== null;
                }
                
                public function directoryExists(string $path): bool {
                    return true; // Google Drive always has directories
                }
                
                public function write(string $path, string $contents, Config $config): void {
                    // Check if file already exists
                    $existingFileId = $this->getFileId($path);
                    
                    if ($existingFileId) {
                        // Update existing file
                        $file = $this->service->files->update($existingFileId, new \Google\Service\Drive\DriveFile(), [
                            'data' => $contents,
                            'mimeType' => $this->getMimeType($path),
                            'uploadType' => 'multipart',
                            'fields' => 'id,webViewLink,webContentLink'
                        ]);
                    } else {
                        // Create new file
                        $fileMetadata = new \Google\Service\Drive\DriveFile([
                            'name' => basename($path),
                            'parents' => $this->folderId ? [$this->folderId] : []
                        ]);
                        
                        $file = $this->service->files->create($fileMetadata, [
                            'data' => $contents,
                            'mimeType' => $this->getMimeType($path),
                            'uploadType' => 'multipart',
                            'fields' => 'id,webViewLink,webContentLink'
                        ]);
                    }
                    
                    $fileId = $file->getId();
                    
                    // Set file permissions to be publicly readable
                    try {
                        $permission = new \Google\Service\Drive\Permission([
                            'type' => 'anyone',
                            'role' => 'reader'
                        ]);
                        $this->service->permissions->create($fileId, $permission);
                    } catch (\Exception $e) {
                        // Log error but don't fail the upload
                        logger()->warning('Failed to set Google Drive file permissions', [
                            'file_id' => $fileId,
                            'error' => $e->getMessage()
                        ]);
                    }
                    
                    // Cache the file info for URL generation
                    $this->fileCache[$path] = [
                        'id' => $fileId,
                        'webViewLink' => $file->getWebViewLink(),
                        'webContentLink' => $file->getWebContentLink()
                    ];
                }
                
                public function writeStream(string $path, $contents, Config $config): void {
                    $this->write($path, stream_get_contents($contents), $config);
                }
                
                public function read(string $path): string {
                    $fileId = $this->getFileId($path);
                    if (!$fileId) {
                        throw new \Exception('File not found: ' . $path);
                    }
                    
                    $response = $this->service->files->get($fileId, ['alt' => 'media']);
                    return $response->getBody()->getContents();
                }
                
                public function readStream(string $path) {
                    $content = $this->read($path);
                    $stream = fopen('php://temp', 'r+');
                    fwrite($stream, $content);
                    rewind($stream);
                    return $stream;
                }
                
                public function delete(string $path): void {
                    $fileId = $this->getFileId($path);
                    if ($fileId) {
                        $this->service->files->delete($fileId);
                        unset($this->fileCache[$path]);
                    }
                }
                
                public function deleteDirectory(string $path): void {
                    // Google Drive doesn't need explicit directory deletion
                }
                
                public function createDirectory(string $path, Config $config): void {
                    // Google Drive creates directories automatically
                }
                
                public function setVisibility(string $path, string $visibility): void {
                    // Google Drive visibility is handled at the file level
                }
                
                public function visibility(string $path): FileAttributes {
                    return new \League\Flysystem\FileAttributes($path, null, 'public');
                }
                
                public function mimeType(string $path): FileAttributes {
                    return new \League\Flysystem\FileAttributes($path, null, null, null, $this->getMimeType($path));
                }
                
                public function lastModified(string $path): FileAttributes {
                    return new \League\Flysystem\FileAttributes($path, null, null, time());
                }
                
                public function fileSize(string $path): FileAttributes {
                    return new \League\Flysystem\FileAttributes($path, null);
                }
                
                public function listContents(string $path, bool $deep): iterable {
                    return []; // Simplified for now
                }
                
                public function move(string $source, string $destination, Config $config): void {
                    // Not implemented for now
                }
                
                public function copy(string $source, string $destination, Config $config): void {
                    // Not implemented for now
                }
                
                public function url($path) {
                    // Get file ID from cache or search
                    $fileId = null;
                    if (isset($this->fileCache[$path])) {
                        $fileId = $this->fileCache[$path]['id'];
                    } else {
                        $fileId = $this->getFileId($path);
                    }
                    
                    if ($fileId) {
                        // Use Google's CDN URL format - more reliable, no CORS issues
                        // This format works better with browsers and doesn't trigger CORB
                        return "https://lh3.googleusercontent.com/d/{$fileId}";
                    }
                    
                    return null;
                }
                
                private function getFileId($path) {
                    if (isset($this->fileCache[$path])) {
                        return $this->fileCache[$path]['id'];
                    }
                    
                    $files = $this->service->files->listFiles([
                        'q' => "name='" . basename($path) . "'" . ($this->folderId ? " and parents in '" . $this->folderId . "'" : ""),
                        'fields' => 'files(id, name)'
                    ]);
                    
                    if (!empty($files->getFiles())) {
                        $fileId = $files->getFiles()[0]->getId();
                        $this->fileCache[$path] = ['id' => $fileId];
                        return $fileId;
                    }
                    
                    return null;
                }
                
                private function getMimeType($path) {
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    $mimeTypes = [
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'pdf' => 'application/pdf',
                        'doc' => 'application/msword',
                        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'txt' => 'text/plain',
                    ];
                    
                    return $mimeTypes[$extension] ?? 'application/octet-stream';
                }
            };

            $filesystem = new Filesystem($adapter, $config);
            $laravelAdapter = new LaravelFilesystemAdapter($filesystem, $adapter, $config);
            
            // Override the url method to use our custom adapter's url method
            return new class($filesystem, $adapter, $config) extends LaravelFilesystemAdapter {
                private $customAdapter;
                
                public function __construct($driver, $adapter, $config)
                {
                    parent::__construct($driver, $adapter, $config);
                    $this->customAdapter = $adapter;
                }
                
                public function url($path)
                {
                    // Use our custom adapter's url method
                    if (method_exists($this->customAdapter, 'url')) {
                        $url = $this->customAdapter->url($path);
                        if ($url) {
                            return $url;
                        }
                    }
                    
                    // Fallback to parent method
                    try {
                        return parent::url($path);
                    } catch (\Exception $e) {
                        // Return a safe fallback
                        return '#';
                    }
                }
            };
        });
    }
}
