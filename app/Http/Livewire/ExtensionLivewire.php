<?php

namespace App\Http\Livewire;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExtensionLivewire extends BaseLivewireComponent
{
    // Override parent's showDetails to show extensions by default
    public $showDetails = true;

    protected $listeners = [
        'refreshView' => '$refresh',
    ];

    public function render()
    {
        // Get all active extensions except Emailer (which has its own menu item)
        $extensions = \App\Models\Extension::where('is_active', true)
            ->where('action', '!=', 'showEmailerView')
            ->get();
        
        return view('livewire.extensions.index', [
            'extensions' => $extensions
        ]);
    }


    //
    public function installExtension()
    {
        try {

            $this->isDemo();

            if ($this->photo == null) {
                $this->showWarningAlert(__('Please select extension file'));
                return;
            }


            //
            //store the zip
            $fileLocation = $this->uploadZipFile($this->photo);
            //unzip the file to a temp folder
            $extractedFileLocation = $this->extractZipFile($fileLocation);
            //
            $extensionFolder = $this->newExtensionFolder($extractedFileLocation . "/extension");
            //move the conect of the files to extensions in http flder
            $extensionComponetLocation = $this->moveExtensionFiles($extensionFolder);
            logger("extensionComponetLocation", [$extensionComponetLocation]);
            //call run function in the installer class
            $extensionInstaller = "App\\Http\\Livewire\\Extensions\\" . $extensionComponetLocation . "\\Installer";
            if (!class_exists($extensionInstaller)) {
                $this->showErrorAlert(__("Extension Installation faild!"));
                return;
            }
            $extensionInstallerClass = new $extensionInstaller();
            $extensionInstallerClass->run();

            //
            $this->showSuccessAlert(__("Extension Installation Successful!"));
            
            // Refresh the page to show the new extension
            $this->emit('refreshView');
        } catch (\Exception $ex) {
            logger("Extension Installation", [$ex]);
            $this->showErrorAlert($ex->getMessage() ?? __("Extension Installation") . " " . __('failed!'));
        }
    }


    //
    public function uploadZipFile($file)
    {
        try {
            // Validate file is actually a zip
            $mimeType = $file->getMimeType();
            $extension = $file->getClientOriginalExtension();
            $originalName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            
            logger("Upload file info", [
                'mime_type' => $mimeType,
                'extension' => $extension,
                'original_name' => $originalName,
                'size' => $fileSize,
                'temp_path' => $file->getRealPath()
            ]);

            // Check if file exists in temp location
            if (!file_exists($file->getRealPath())) {
                throw new \Exception("Temporary file not found. Upload may have failed.");
            }

            // Check if it's a zip file by MIME type and extension
            $validMimeTypes = [
                'application/zip',
                'application/x-zip-compressed',
                'application/x-zip',
                'application/octet-stream' // Sometimes Windows sends this
            ];

            if (!in_array($mimeType, $validMimeTypes) && strtolower($extension) !== 'zip') {
                throw new \Exception("Invalid file type. Please upload a valid .zip file. Detected type: " . $mimeType);
            }

            $code = \Str::random(20);
            $extensionFolder = "extensions/" . $code;
            
            // Ensure the extensions directory exists
            $fullPath = storage_path('app/' . $extensionFolder);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
                logger("Created directory", ['path' => $fullPath]);
            }
            
            // Try to store the file explicitly to the 'local' disk
            $storedPath = $file->storeAs($extensionFolder, "extension.zip", 'local');
            $finalPath = storage_path('app/' . $extensionFolder . '/extension.zip');
            
            logger("File store attempt", [
                'stored_path' => $storedPath,
                'final_path' => $finalPath,
                'file_exists' => file_exists($finalPath),
                'storage_disk' => 'local'
            ]);
            
            // If storeAs failed or file doesn't exist, manually copy it
            if (!$storedPath || !file_exists($finalPath)) {
                logger("StoreAs failed, attempting manual copy", [
                    'from' => $file->getRealPath(),
                    'to' => $finalPath
                ]);
                
                // Manually copy the file
                if (!copy($file->getRealPath(), $finalPath)) {
                    throw new \Exception("Failed to copy uploaded file from temp location to: " . $finalPath);
                }
                
                logger("Manual copy successful", ['file_exists' => file_exists($finalPath)]);
            }
            
            // Final verification
            if (!file_exists($finalPath)) {
                throw new \Exception("File was not successfully stored at: " . $finalPath);
            }
            
            logger("File successfully stored", [
                'path' => $finalPath,
                'size' => filesize($finalPath)
            ]);
            
            return $extensionFolder;
        } catch (\Exception $ex) {
            logger("Upload Error", ['error' => $ex->getMessage(), 'trace' => $ex->getTraceAsString()]);
            throw $ex;
        }
    }

    //
    public function moveExtensionFiles($extensionFolder)
    {
        $extensionComponetLocation = "";
        //
        $files = scandir($extensionFolder);
        foreach ($files as $file) {
            //move extion folders
            switch ($file) {
                case 'js':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/public/js/extensions";
                    $this->copyFile($from, $to);
                    logger("Copied js files", ['from' => $from, 'to' => $to]);
                    break;

                case 'css':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/public/css/extensions";
                    $this->copyFile($from, $to);
                    logger("Copied css files", ['from' => $from, 'to' => $to]);
                    break;

                case 'images':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/public/images/extensions";
                    $this->copyFile($from, $to);
                    logger("Copied image files", ['from' => $from, 'to' => $to]);
                    break;

                case 'view':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/resources/views/livewire/extensions";
                    $this->copyFile($from, $to);
                    logger("Copied view files", ['from' => $from, 'to' => $to]);
                    break;

                case 'extension':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/app/Http/Livewire/Extensions";
                    $this->copyFile($from, $to);
                    logger("Copied extension files", ['from' => $from, 'to' => $to]);

                    $files = scandir($extensionFolder . "/" . $file);
                    foreach ($files as $file) {
                        if ($file[0] != '.') {
                            $extensionComponetLocation = $file;
                            break;
                        }
                    }
                    
                    // Verify the extension folder was created
                    $extensionPath = base_path() . "/app/Http/Livewire/Extensions/" . $extensionComponetLocation;
                    if (!file_exists($extensionPath)) {
                        throw new \Exception("Extension folder was not created at: " . $extensionPath);
                    }
                    logger("Extension folder verified", ['path' => $extensionPath]);
                    //
                    break;
                case 'vendor':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/vendor";
                    $this->copyFile($from, $to);
                    logger("Copied vendor files", ['from' => $from, 'to' => $to]);
                    break;

                default:
                    # code...
                    break;
            }
            //move extion folders

        }
        return $extensionComponetLocation;
    }

    public function copyFile($from, $to)
    {
        // Remove trailing "/." from path
        $from = rtrim($from, '/.');
        
        // Create destination directory if it doesn't exist
        if (!file_exists($to)) {
            mkdir($to, 0755, true);
        }
        
        // Check if running on Windows
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Use xcopy for Windows
            $command = 'xcopy "' . $from . '" "' . $to . '" /E /I /Y';
            exec($command);
        } else {
            // Use cp for Unix/Linux with proper syntax to copy contents
            // Add /* to copy contents of directory, and use -r for recursive
            $process = new Process(['cp', '-r', $from . '/.', $to]);
            $process->setWorkingDirectory(base_path());
            $process->run();
            
            // Log any errors for debugging
            if (!$process->isSuccessful()) {
                logger("Copy File Error", [
                    'from' => $from,
                    'to' => $to,
                    'error' => $process->getErrorOutput(),
                    'output' => $process->getOutput()
                ]);
            }
        }
    }

    //
    public function newExtensionFolder($location)
    {
        $foldFound = "";
        //
        $files = scandir($location);
        foreach ($files as $file) {
            if (!in_array($file, [".", "..", "__MACOSX"])) {
                $foldFound = $file;
                break;
            }
        }

        return $location . "/" . $foldFound;
    }

    public function extractZipFile($location)
    {
        $workDir = storage_path() . "/app/" . $location;
        $zipFile = $workDir . "/extension.zip";
        $extractTo = $workDir . "/extension";

        try {
            // Validate zip file exists
            if (!file_exists($zipFile)) {
                throw new \Exception("Extension zip file not found at: " . $zipFile);
            }

            // Check if file is readable
            if (!is_readable($zipFile)) {
                throw new \Exception("Extension zip file is not readable. Please check file permissions.");
            }

            // Validate file size
            $fileSize = filesize($zipFile);
            logger("Zip file info", [
                'path' => $zipFile,
                'size' => $fileSize,
                'readable' => is_readable($zipFile)
            ]);

            if ($fileSize === 0) {
                throw new \Exception("Extension zip file is empty (0 bytes). Upload may have failed.");
            }

            // Create extraction directory if it doesn't exist
            if (!file_exists($extractTo)) {
                mkdir($extractTo, 0755, true);
            }

            // Check if ZipArchive is available
            if (class_exists('ZipArchive')) {
                $zip = new \ZipArchive;
                $res = $zip->open($zipFile);
                
                if ($res === TRUE) {
                    $zip->extractTo($extractTo);
                    $zip->close();
                    logger("Zip Extract", ["Successfully extracted using ZipArchive"]);
                } else {
                    // Provide more detailed error messages
                    $errorMessages = [
                        \ZipArchive::ER_EXISTS => "File already exists",
                        \ZipArchive::ER_INCONS => "Zip archive inconsistent",
                        \ZipArchive::ER_INVAL => "Invalid argument",
                        \ZipArchive::ER_MEMORY => "Malloc failure",
                        \ZipArchive::ER_NOENT => "No such file",
                        \ZipArchive::ER_NOZIP => "Not a valid zip archive",
                        \ZipArchive::ER_OPEN => "Can't open file",
                        \ZipArchive::ER_READ => "Read error",
                        \ZipArchive::ER_SEEK => "Seek error",
                    ];
                    
                    $errorMsg = isset($errorMessages[$res]) ? $errorMessages[$res] : "Unknown error";
                    logger("Zip Error Details", [
                        'code' => $res,
                        'message' => $errorMsg,
                        'file' => $zipFile,
                        'file_size' => $fileSize
                    ]);
                    
                    throw new \Exception("Failed to open zip file. Error: " . $errorMsg . " (Code: " . $res . "). The uploaded file may be corrupted. Please try re-downloading and uploading the extension.");
                }
            } else {
                // Fallback to command line for Unix/Linux systems
                if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
                    // Update permission on Unix/Linux
                    $process = new Process(explode(" ", "chmod 777 extension.zip"));
                    $process->setWorkingDirectory($workDir);
                    $process->run();

                    // Unzip
                    $process = new Process(explode(" ", "unzip extension.zip -d extension"));
                    $process->setWorkingDirectory($workDir);
                    $process->run();

                    if (!$process->isSuccessful()) {
                        logger("Unzip Process error", [new ProcessFailedException($process)]);
                        throw new \Exception("Failed to extract zip file using unzip command");
                    }
                    logger("Unzip Process output", ["Done"]);
                } else {
                    throw new \Exception("ZipArchive extension is not installed on this server");
                }
            }
            
            logger("Done Extract", ["Yes"]);
        } catch (\Exception $ex) {
            logger("Unzip Error", [$ex->getMessage()]);
            throw $ex;
        }

        return $workDir;
    }
}