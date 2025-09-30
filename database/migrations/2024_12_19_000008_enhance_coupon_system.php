<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnhanceCouponSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add new columns to coupons table for enhanced management
        Schema::table('coupons', function (Blueprint $table) {
            // Add new fields for better coupon management
            $table->boolean('for_new_users_only')->default(false)->after('for_delivery');
            $table->boolean('for_zero_waste_module')->default(false)->after('for_new_users_only');
            $table->text('usage_instructions')->nullable()->after('for_zero_waste_module');
            $table->integer('max_uses_per_user')->nullable()->after('times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn([
                'for_new_users_only',
                'for_zero_waste_module', 
                'usage_instructions',
                'max_uses_per_user'
            ]);
        });
    }
}
