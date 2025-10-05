<?php

namespace Database\Seeders;

use App\Models\DynamicPricingRule;
use Illuminate\Database\Seeder;

class DynamicPricingRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Peak hours rule for delivery
        DynamicPricingRule::create([
            'name' => 'Peak Hours - Delivery',
            'description' => 'Higher pricing during peak delivery hours (11:00-14:00 and 18:00-21:00)',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '11:00:00',
            'end_time' => '14:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7], // All days
            'base_multiplier' => 1.3,
            'distance_multiplier' => 1.2,
            'time_multiplier' => 1.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.5,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 1
        ]);

        // Evening peak hours rule
        DynamicPricingRule::create([
            'name' => 'Evening Peak Hours - Delivery',
            'description' => 'Higher pricing during evening peak hours (18:00-21:00)',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '18:00:00',
            'end_time' => '21:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7], // All days
            'base_multiplier' => 1.4,
            'distance_multiplier' => 1.3,
            'time_multiplier' => 1.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.5,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 1
        ]);

        // Weekend pricing rule
        DynamicPricingRule::create([
            'name' => 'Weekend Pricing - Delivery',
            'description' => 'Higher pricing on weekends',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'days_of_week' => [6, 7], // Saturday and Sunday
            'base_multiplier' => 1.2,
            'distance_multiplier' => 1.1,
            'time_multiplier' => 1.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.0,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 2
        ]);

        // Late night pricing rule
        DynamicPricingRule::create([
            'name' => 'Late Night Pricing - Delivery',
            'description' => 'Higher pricing for late night deliveries (22:00-06:00)',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '22:00:00',
            'end_time' => '06:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7], // All days
            'base_multiplier' => 1.5,
            'distance_multiplier' => 1.3,
            'time_multiplier' => 1.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 3.0,
            'low_demand_threshold' => 3,
            'high_demand_threshold' => 10,
            'critical_demand_threshold' => 20,
            'is_active' => true,
            'priority' => 3
        ]);

        // Package delivery peak hours
        DynamicPricingRule::create([
            'name' => 'Peak Hours - Package Delivery',
            'description' => 'Higher pricing during peak package delivery hours (09:00-17:00)',
            'service_type' => 'package',
            'rule_type' => 'time_based',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'days_of_week' => [1, 2, 3, 4, 5], // Weekdays only
            'base_multiplier' => 1.2,
            'distance_multiplier' => 1.1,
            'time_multiplier' => 1.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.0,
            'low_demand_threshold' => 3,
            'high_demand_threshold' => 10,
            'critical_demand_threshold' => 20,
            'is_active' => true,
            'priority' => 1
        ]);

        // Taxi rush hour pricing
        DynamicPricingRule::create([
            'name' => 'Rush Hour - Taxi',
            'description' => 'Higher pricing during rush hours (07:00-09:00 and 17:00-19:00)',
            'service_type' => 'taxi',
            'rule_type' => 'time_based',
            'start_time' => '07:00:00',
            'end_time' => '09:00:00',
            'days_of_week' => [1, 2, 3, 4, 5], // Weekdays only
            'base_multiplier' => 1.4,
            'distance_multiplier' => 1.3,
            'time_multiplier' => 1.2,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.5,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 1
        ]);

        // Evening rush hour for taxi
        DynamicPricingRule::create([
            'name' => 'Evening Rush Hour - Taxi',
            'description' => 'Higher pricing during evening rush hours (17:00-19:00)',
            'service_type' => 'taxi',
            'rule_type' => 'time_based',
            'start_time' => '17:00:00',
            'end_time' => '19:00:00',
            'days_of_week' => [1, 2, 3, 4, 5], // Weekdays only
            'base_multiplier' => 1.4,
            'distance_multiplier' => 1.3,
            'time_multiplier' => 1.2,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.5,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 1
        ]);

        // Weekend taxi pricing
        DynamicPricingRule::create([
            'name' => 'Weekend Pricing - Taxi',
            'description' => 'Higher pricing for taxi services on weekends',
            'service_type' => 'taxi',
            'rule_type' => 'time_based',
            'days_of_week' => [6, 7], // Saturday and Sunday
            'base_multiplier' => 1.3,
            'distance_multiplier' => 1.2,
            'time_multiplier' => 1.1,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.0,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 2
        ]);

        // Late night taxi pricing
        DynamicPricingRule::create([
            'name' => 'Late Night Pricing - Taxi',
            'description' => 'Higher pricing for late night taxi services (23:00-05:00)',
            'service_type' => 'taxi',
            'rule_type' => 'time_based',
            'start_time' => '23:00:00',
            'end_time' => '05:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7], // All days
            'base_multiplier' => 1.6,
            'distance_multiplier' => 1.4,
            'time_multiplier' => 1.3,
            'min_multiplier' => 1.0,
            'max_multiplier' => 3.0,
            'low_demand_threshold' => 3,
            'high_demand_threshold' => 10,
            'critical_demand_threshold' => 20,
            'is_active' => true,
            'priority' => 3
        ]);
    }
}
