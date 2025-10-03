<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ImproveCouponUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupon_user', function (Blueprint $table) {
            // Add timestamps if they don't exist
            if (!Schema::hasColumn('coupon_user', 'created_at')) {
                $table->timestamps();
            }
            
            // Add indexes for better performance
            $table->index(['coupon_id', 'user_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('order_id');
        });

        // Add indexes to coupons table for better performance
        Schema::table('coupons', function (Blueprint $table) {
            $table->index(['code', 'is_active']);
            $table->index(['expires_on', 'is_active']);
            $table->index('vendor_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_user', function (Blueprint $table) {
            $table->dropIndex(['coupon_id', 'user_id']);
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['order_id']);
        });

        Schema::table('coupons', function (Blueprint $table) {
            $table->dropIndex(['code', 'is_active']);
            $table->dropIndex(['expires_on', 'is_active']);
            $table->dropIndex(['vendor_type_id']);
        });
    }
}
