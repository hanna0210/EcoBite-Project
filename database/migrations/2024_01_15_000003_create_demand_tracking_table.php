<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demand_tracking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('service_type', ['delivery', 'package', 'taxi'])->default('delivery');
            
            // Location data (rounded to reduce precision for privacy)
            $table->decimal('latitude', 8, 4); // Reduced precision for area-based tracking
            $table->decimal('longitude', 9, 4); // Reduced precision for area-based tracking
            $table->string('area_code', 20)->nullable(); // City/area identifier
            
            // Time data
            $table->date('tracking_date');
            $table->time('tracking_time');
            $table->integer('hour_of_day'); // 0-23 for easier aggregation
            
            // Demand metrics
            $table->integer('orders_count')->default(0);
            $table->integer('pending_orders')->default(0);
            $table->integer('active_drivers')->default(0);
            $table->integer('available_drivers')->default(0);
            $table->decimal('average_wait_time', 8, 2)->default(0.00); // in minutes
            $table->decimal('average_delivery_time', 8, 2)->default(0.00); // in minutes
            
            // Calculated metrics
            $table->decimal('demand_supply_ratio', 5, 2)->default(0.00);
            $table->integer('demand_level')->default(0); // 0=low, 1=medium, 2=high, 3=critical
            $table->decimal('recommended_multiplier', 5, 2)->default(1.00);
            
            // External factors
            $table->string('weather_condition')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_weekend')->default(false);
            $table->string('special_event')->nullable();
            
            $table->timestamps();
            
            // Indexes for efficient queries
            $table->index(['vendor_id', 'tracking_date', 'hour_of_day']);
            $table->index(['service_type', 'tracking_date', 'hour_of_day']);
            $table->index(['latitude', 'longitude', 'tracking_date']);
            $table->index(['area_code', 'tracking_date', 'hour_of_day']);
            $table->index(['demand_level', 'tracking_date']);
            
            // Unique constraint to prevent duplicates
            $table->unique(['vendor_id', 'service_type', 'latitude', 'longitude', 'tracking_date', 'hour_of_day'], 'unique_demand_tracking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demand_tracking');
    }
}
