<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;

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
                return new \League\Flysystem\Filesystem(new class {
                    public function write($path, $contents, $config = []) {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function read($path) {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function delete($path) {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                    
                    public function has($path) {
                        return false;
                    }
                    
                    public function url($path) {
                        throw new \Exception('Google Drive credentials not configured. Please set GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET, and GOOGLE_DRIVE_REFRESH_TOKEN in your .env file.');
                    }
                });
            }

            $client = new Client();
            $client->setClientId($config['clientId']);
            $client->setClientSecret($config['clientSecret']);
            $client->refreshToken($config['refreshToken']);

            $service = new Drive($client);
            
            // Create a comprehensive adapter that implements the filesystem interface
            $adapter = new class($service, $config['folderId']) {
                private $service;
                private $folderId;
                private $fileCache = [];
                
                public function __construct($service, $folderId) {
                    $this->service = $service;
                    $this->folderId = $folderId;
                }
                
                public function write($path, $contents, $config = []) {
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
                    
                    // Cache the file info for URL generation
                    $this->fileCache[$path] = [
                        'id' => $file->getId(),
                        'webViewLink' => $file->getWebViewLink(),
                        'webContentLink' => $file->getWebContentLink()
                    ];
                    
                    return ['path' => $path, 'type' => 'file'];
                }
                
                public function read($path) {
                    $fileId = $this->getFileId($path);
                    if (!$fileId) {
                        throw new \Exception('File not found: ' . $path);
                    }
                    
                    $response = $this->service->files->get($fileId, ['alt' => 'media']);
                    return $response->getBody()->getContents();
                }
                
                public function delete($path) {
                    $fileId = $this->getFileId($path);
                    if ($fileId) {
                        $this->service->files->delete($fileId);
                        unset($this->fileCache[$path]);
                    }
                    return true;
                }
                
                public function has($path) {
                    return $this->getFileId($path) !== null;
                }
                
                public function url($path) {
                    if (isset($this->fileCache[$path])) {
                        return $this->fileCache[$path]['webContentLink'];
                    }
                    
                    $fileId = $this->getFileId($path);
                    if ($fileId) {
                        $file = $this->service->files->get($fileId, ['fields' => 'webContentLink']);
                        return $file->getWebContentLink();
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

            return new \League\Flysystem\Filesystem($adapter);
        });
    }
}
