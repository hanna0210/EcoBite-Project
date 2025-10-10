<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodRescue;
use App\Models\Vendor;
use Carbon\Carbon;

class FoodRescueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get active vendors
        $vendors = Vendor::where('is_active', 1)->get();

        if ($vendors->isEmpty()) {
            $this->command->warn('No active vendors found. Please seed vendors first.');
            return;
        }

        $this->command->info('Creating food rescue offers...');

        $foodRescues = [
            [
                'title' => 'Fresh Bakery Items - End of Day Special',
                'description' => 'Assorted fresh bread, pastries, and baked goods from today. Perfect condition, just closing time surplus. Includes croissants, baguettes, muffins, and cookies.',
                'original_price' => 15.00,
                'rescue_price' => 7.50,
                'available_quantity' => 5,
                'total_quantity' => 10,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(3),
                'is_active' => true,
                'pickup_instructions' => 'Pick up at the back entrance. Ring the bell and mention "rescue offer".',
                'tags' => ['Bakery', 'Fresh Produce', 'Vegetarian'],
            ],
            [
                'title' => 'Surplus Vegetables & Fruits',
                'description' => 'Fresh organic vegetables and fruits. Slightly imperfect appearance but perfect taste and nutrition. Includes tomatoes, cucumbers, apples, and bananas.',
                'original_price' => 12.00,
                'rescue_price' => 5.00,
                'available_quantity' => 8,
                'total_quantity' => 15,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(6),
                'is_active' => true,
                'pickup_instructions' => 'Available during business hours. Ask staff for rescue package.',
                'tags' => ['Fresh Produce', 'Vegan', 'Organic'],
            ],
            [
                'title' => 'Ready-to-Eat Meals',
                'description' => 'Delicious prepared meals from today\'s menu. Includes rice bowls, pasta, and salads. Perfectly safe and tasty, just closing time surplus.',
                'original_price' => 20.00,
                'rescue_price' => 10.00,
                'available_quantity' => 3,
                'total_quantity' => 8,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(2),
                'is_active' => true,
                'pickup_instructions' => 'Pickup before 8 PM. Meals are packed and ready to go.',
                'tags' => ['Prepared Meals', 'Vegetarian'],
            ],
            [
                'title' => 'Dairy Products Surplus',
                'description' => 'Fresh dairy products with short best-before dates. Includes milk, yogurt, cheese, and butter. All perfectly safe for immediate consumption.',
                'original_price' => 18.00,
                'rescue_price' => 8.00,
                'available_quantity' => 6,
                'total_quantity' => 12,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(4),
                'is_active' => true,
                'pickup_instructions' => 'Keep refrigerated. Pick up as soon as possible.',
                'tags' => ['Dairy', 'Fresh Produce'],
            ],
            [
                'title' => 'Snacks & Beverages Bundle',
                'description' => 'Variety pack of snacks and drinks. Perfect for parties or home stocking. Includes chips, cookies, juice boxes, and soft drinks.',
                'original_price' => 25.00,
                'rescue_price' => 12.00,
                'available_quantity' => 10,
                'total_quantity' => 20,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(8),
                'is_active' => true,
                'pickup_instructions' => 'Large box - bring a bag. Available at front counter.',
                'tags' => ['Snacks', 'Beverages'],
            ],
            [
                'title' => 'Fresh Meat & Seafood Box',
                'description' => 'Premium quality meat and seafood. Includes chicken, fish, and shrimp. Must be cooked within 24 hours.',
                'original_price' => 30.00,
                'rescue_price' => 15.00,
                'available_quantity' => 4,
                'total_quantity' => 8,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(5),
                'is_active' => true,
                'pickup_instructions' => 'Bring cooler bag. Available at meat counter.',
                'tags' => ['Meat & Seafood', 'Fresh Produce'],
            ],
            [
                'title' => 'Vegan Meal Prep Package',
                'description' => '100% plant-based prepared meals. Includes quinoa bowls, veggie wraps, and smoothie ingredients. Healthy and delicious!',
                'original_price' => 22.00,
                'rescue_price' => 11.00,
                'available_quantity' => 7,
                'total_quantity' => 12,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(6),
                'is_active' => true,
                'pickup_instructions' => 'All meals are clearly labeled. Ask for vegan rescue package.',
                'tags' => ['Prepared Meals', 'Vegan', 'Organic', 'Gluten-Free'],
            ],
            [
                'title' => 'Frozen Foods Clearance',
                'description' => 'Assorted frozen items including ice cream, frozen vegetables, and frozen meals. Perfect quality, just need to move inventory.',
                'original_price' => 16.00,
                'rescue_price' => 7.00,
                'available_quantity' => 15,
                'total_quantity' => 25,
                'available_from' => Carbon::now(),
                'available_until' => Carbon::now()->addHours(10),
                'is_active' => true,
                'pickup_instructions' => 'Keep frozen immediately after pickup. Large quantity available.',
                'tags' => ['Frozen Foods', 'Snacks'],
            ],
        ];

        // Distribute food rescues across vendors
        $vendorIndex = 0;
        foreach ($foodRescues as $index => $rescue) {
            // Cycle through vendors
            $vendor = $vendors[$vendorIndex % $vendors->count()];
            
            $foodRescue = FoodRescue::create([
                'title' => $rescue['title'],
                'description' => $rescue['description'],
                'original_price' => $rescue['original_price'],
                'rescue_price' => $rescue['rescue_price'],
                'available_quantity' => $rescue['available_quantity'],
                'total_quantity' => $rescue['total_quantity'],
                'available_from' => $rescue['available_from'],
                'available_until' => $rescue['available_until'],
                'vendor_id' => $vendor->id,
                'is_active' => $rescue['is_active'],
                'pickup_instructions' => $rescue['pickup_instructions'],
                'tags' => $rescue['tags'],
            ]);

            // Add sample image (using vendor's logo as placeholder)
            if ($vendor->logo) {
                try {
                    $foodRescue->addMediaFromUrl($vendor->logo)
                        ->toMediaCollection('default');
                } catch (\Exception $e) {
                    $this->command->warn("Could not add image for: {$rescue['title']}");
                }
            }

            $this->command->info("Created: {$rescue['title']} for {$vendor->name}");
            $vendorIndex++;
        }

        $this->command->info('Food rescue seeding completed successfully!');
        $this->command->info('Total offers created: ' . count($foodRescues));
    }
}

