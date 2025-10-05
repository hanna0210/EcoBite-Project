<?php

namespace Tests\Feature;

use App\Models\DynamicPricingRule;
use App\Models\Vendor;
use App\Services\DynamicPricingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DynamicPricingTest extends TestCase
{
    use RefreshDatabase;

    protected $dynamicPricingService;
    protected $vendor;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->dynamicPricingService = app(DynamicPricingService::class);
        
        // Create a test vendor
        $this->vendor = Vendor::factory()->create([
            'name' => 'Test Vendor',
            'is_active' => true
        ]);
    }

    /** @test */
    public function it_can_calculate_dynamic_pricing_for_delivery()
    {
        // Create a peak hours pricing rule
        DynamicPricingRule::create([
            'name' => 'Peak Hours Test',
            'description' => 'Test peak hours rule',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '11:00:00',
            'end_time' => '14:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7],
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

        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'delivery',
            'base_price' => 5.00,
            'distance_price' => 10.00,
            'time_price' => 0,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertGreaterThan($result['original_price'], $result['dynamic_price']);
        $this->assertArrayHasKey('multipliers', $result);
        $this->assertArrayHasKey('demand_level', $result);
    }

    /** @test */
    public function it_returns_original_price_when_no_rules_apply()
    {
        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'delivery',
            'base_price' => 5.00,
            'distance_price' => 10.00,
            'time_price' => 0,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertEquals($result['original_price'], $result['dynamic_price']);
    }

    /** @test */
    public function it_can_calculate_dynamic_pricing_for_package_delivery()
    {
        // Create a package delivery pricing rule
        DynamicPricingRule::create([
            'name' => 'Package Peak Hours',
            'description' => 'Test package peak hours rule',
            'service_type' => 'package',
            'rule_type' => 'time_based',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'days_of_week' => [1, 2, 3, 4, 5],
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

        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'package',
            'base_price' => 10.00,
            'distance_price' => 15.00,
            'time_price' => 5.00,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertGreaterThan($result['original_price'], $result['dynamic_price']);
    }

    /** @test */
    public function it_can_calculate_dynamic_pricing_for_taxi()
    {
        // Create a taxi rush hour pricing rule
        DynamicPricingRule::create([
            'name' => 'Taxi Rush Hour',
            'description' => 'Test taxi rush hour rule',
            'service_type' => 'taxi',
            'rule_type' => 'time_based',
            'start_time' => '07:00:00',
            'end_time' => '09:00:00',
            'days_of_week' => [1, 2, 3, 4, 5],
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

        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'taxi',
            'base_price' => 3.00,
            'distance_price' => 2.50,
            'time_price' => 1.00,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertGreaterThan($result['original_price'], $result['dynamic_price']);
    }

    /** @test */
    public function it_respects_multiplier_bounds()
    {
        // Create a rule with high multipliers
        DynamicPricingRule::create([
            'name' => 'High Multiplier Test',
            'description' => 'Test high multiplier rule',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '11:00:00',
            'end_time' => '14:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7],
            'base_multiplier' => 5.0, // Very high
            'distance_multiplier' => 5.0,
            'time_multiplier' => 5.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 2.0, // Should cap at 2.0
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => true,
            'priority' => 1
        ]);

        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'delivery',
            'base_price' => 5.00,
            'distance_price' => 10.00,
            'time_price' => 0,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertLessThanOrEqual(2.0, $result['multipliers']['base']);
    }

    /** @test */
    public function it_handles_inactive_rules()
    {
        // Create an inactive rule
        DynamicPricingRule::create([
            'name' => 'Inactive Rule',
            'description' => 'Test inactive rule',
            'service_type' => 'delivery',
            'rule_type' => 'time_based',
            'start_time' => '11:00:00',
            'end_time' => '14:00:00',
            'days_of_week' => [1, 2, 3, 4, 5, 6, 7],
            'base_multiplier' => 2.0,
            'distance_multiplier' => 2.0,
            'time_multiplier' => 2.0,
            'min_multiplier' => 1.0,
            'max_multiplier' => 3.0,
            'low_demand_threshold' => 5,
            'high_demand_threshold' => 15,
            'critical_demand_threshold' => 30,
            'is_active' => false, // Inactive
            'priority' => 1
        ]);

        $orderData = [
            'vendor_id' => $this->vendor->id,
            'service_type' => 'delivery',
            'base_price' => 5.00,
            'distance_price' => 10.00,
            'time_price' => 0,
            'latitude' => 40.7128,
            'longitude' => -74.0060
        ];

        $result = $this->dynamicPricingService->calculateDynamicPrice($orderData);

        $this->assertTrue($result['success']);
        $this->assertEquals($result['original_price'], $result['dynamic_price']);
    }
}
