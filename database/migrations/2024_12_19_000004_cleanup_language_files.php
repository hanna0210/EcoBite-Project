<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class CleanupLanguageFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $langPath = resource_path('lang');
        $keepLanguages = ['en', 'es', 'pt-br'];
        
        // Get all directories in lang folder
        $directories = File::directories($langPath);
        
        foreach ($directories as $directory) {
            $dirName = basename($directory);
            if (!in_array($dirName, $keepLanguages)) {
                File::deleteDirectory($directory);
            }
        }
        
        // Get all JSON files in lang folder
        $jsonFiles = File::glob($langPath . '/*.json');
        
        foreach ($jsonFiles as $jsonFile) {
            $fileName = basename($jsonFile, '.json');
            if (!in_array($fileName, $keepLanguages)) {
                File::delete($jsonFile);
            }
        }
        
        // Also delete .DS_Store file if it exists
        $dsStorePath = $langPath . '/.DS_Store';
        if (File::exists($dsStorePath)) {
            File::delete($dsStorePath);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Note: This migration cannot be reversed as files are permanently deleted
        // You would need to restore from backup or reinstall the application
    }
}
