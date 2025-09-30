<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ConfigureMediaLibraryForGoogleDrive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update media library configuration to use Google Drive
        // This will be handled by environment variable MEDIA_DISK=gdrive
        // The actual configuration is in .env file
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to local storage
        // This will be handled by environment variable MEDIA_DISK=public
    }
}
