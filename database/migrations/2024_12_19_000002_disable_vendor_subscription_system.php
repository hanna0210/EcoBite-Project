<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DisableVendorSubscriptionSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Disable vendor subscription system by default
        DB::table('settings')->updateOrInsert(
            ['key' => 'vendorUseSubscriptionDefault'],
            [
                'value' => '0', // Disable by default
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
        // Re-enable vendor subscription system
        DB::table('settings')->updateOrInsert(
            ['key' => 'vendorUseSubscriptionDefault'],
            [
                'value' => '1', // Enable by default
                'updated_at' => now(),
            ]
        );
    }
}
