<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnableReferralSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Enable referral system
        DB::table('settings')->updateOrInsert(
            ['key' => 'enableReferSystem'],
            [
                'value' => '1', // Enable referral system
                'updated_at' => now(),
            ]
        );
        
        // Set referral reward amount
        DB::table('settings')->updateOrInsert(
            ['key' => 'referRewardAmount'],
            [
                'value' => '5.00', // $5.00 reward for referrals
                'updated_at' => now(),
            ]
        );
        
        // Enable referral reward on registration
        DB::table('settings')->updateOrInsert(
            ['key' => 'enableOnRegistrationReferReward'],
            [
                'value' => '1', // Enable immediate reward
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
        // Disable referral system
        DB::table('settings')->updateOrInsert(
            ['key' => 'enableReferSystem'],
            [
                'value' => '0', // Disable referral system
                'updated_at' => now(),
            ]
        );
    }
}
