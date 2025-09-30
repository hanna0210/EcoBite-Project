<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCountryCodeToHonduras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update country code to Honduras (HN)
        DB::table('settings')->updateOrInsert(
            ['key' => 'countryCode'],
            [
                'value' => 'HN', // Honduras
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert to Ghana (GH)
        DB::table('settings')->updateOrInsert(
            ['key' => 'countryCode'],
            [
                'value' => 'GH', // Ghana
                'updated_at' => now(),
            ]
        );
    }
}
