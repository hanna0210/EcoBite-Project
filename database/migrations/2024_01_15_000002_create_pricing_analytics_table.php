<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('dynamic_pricing_rule_id')->nullable()->constrained()->onDelete('set null');
            
            // Pricing data
            $table->decimal('base_price', 10, 2)->default(0.00);
            $table->decimal('original_price', 10, 2)->default(0.00);
            $table->decimal('dynamic_price', 10, 2)->default(0.00);
            $table->decimal('multiplier_applied', 5, 2)->default(1.00);
            
            // Context data
            $table->enum('service_type', ['delivery', 'package', 'taxi'])->default('delivery');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->time('order_time')->nullable();
            $table->date('order_date')->nullable();
            $table->integer('demand_level')->default(0); // Orders in area at time
            $table->integer('supply_level')->default(0); // Available drivers in area
            
            // Weather and external factors
            $table->string('weather_condition')->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_weekend')->default(false);
            $table->string('special_event')->nullable();
            
            // Outcome tracking
            $table->boolean('order_accepted')->nullable(); // null = pending, true = accepted, false = rejected
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes for analytics queries
            $table->index(['vendor_id', 'order_date', 'order_time']);
            $table->index(['service_type', 'order_date']);
            $table->index(['latitude', 'longitude', 'order_date']);
            $table->index(['demand_level', 'supply_level']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_analytics');
    }
}
