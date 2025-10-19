<?php

namespace App\Http\Livewire;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExtensionLivewire extends BaseLivewireComponent
{

    public function render()
    {
        return view('livewire.extensions.index');
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
        } catch (\Exception $ex) {
            logger("Extension Installation", [$ex]);
            $this->showErrorAlert($ex->getMessage() ?? __("Extension Installation") . " " . __('failed!'));
        }
    }


    //
    public function uploadZipFile($file)
    {
        $code = \Str::random(20);
        $extensionFolder = "extensions/" . $code;
        //
        $file->storeAs($extensionFolder, "extension.zip");
        return $extensionFolder;
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
                    break;

                case 'css':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/public/css/extensions";
                    $this->copyFile($from, $to);
                    break;

                case 'images':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/public/images/extensions";
                    $this->copyFile($from, $to);
                    break;

                case 'view':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/resources/views/livewire/extensions";
                    $this->copyFile($from, $to);
                    break;

                case 'extension':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/app/Http/Livewire/Extensions";
                    $this->copyFile($from, $to);

                    $files = scandir($extensionFolder . "/" . $file);
                    foreach ($files as $file) {
                        if ($file[0] != '.') {
                            $extensionComponetLocation = $file;
                            break;
                        }
                    }
                    //
                    break;
                case 'vendor':
                    $from = $extensionFolder . "/" . $file . "/.";
                    $to = base_path() . "/vendor";
                    $this->copyFile($from, $to);
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
            // Use cp for Unix/Linux
            $process = new Process(explode(" ", "cp -a " . $from . " " . $to . ""));
            $process->setWorkingDirectory(base_path() . "/");
            $process->run();
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
                    throw new \Exception("Failed to open zip file. Error code: " . $res);
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