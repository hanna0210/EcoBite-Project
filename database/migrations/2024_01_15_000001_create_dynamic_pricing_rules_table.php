<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicPricingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('service_type', ['delivery', 'package', 'taxi'])->default('delivery');
            $table->enum('rule_type', ['time_based', 'demand_based', 'location_based', 'weather_based', 'event_based'])->default('time_based');
            
            // Rule conditions
            $table->json('conditions')->nullable(); // Flexible conditions storage
            $table->time('start_time')->nullable(); // For time-based rules
            $table->time('end_time')->nullable(); // For time-based rules
            $table->json('days_of_week')->nullable(); // [1,2,3,4,5] for weekdays
            $table->json('location_conditions')->nullable(); // Geographic conditions
            
            // Pricing adjustments
            $table->decimal('base_multiplier', 5, 2)->default(1.00); // Base price multiplier
            $table->decimal('distance_multiplier', 5, 2)->default(1.00); // Distance price multiplier
            $table->decimal('time_multiplier', 5, 2)->default(1.00); // Time-based multiplier
            $table->decimal('min_multiplier', 5, 2)->default(0.50); // Minimum multiplier
            $table->decimal('max_multiplier', 5, 2)->default(3.00); // Maximum multiplier
            
            // Demand thresholds
            $table->integer('low_demand_threshold')->default(5); // Orders per hour
            $table->integer('high_demand_threshold')->default(20); // Orders per hour
            $table->integer('critical_demand_threshold')->default(50); // Orders per hour
            
            // Status and priority
            $table->boolean('is_active')->default(true);
            $table->integer('priority')->default(1); // Higher number = higher priority
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dynamic_pricing_rules');
    }
}
