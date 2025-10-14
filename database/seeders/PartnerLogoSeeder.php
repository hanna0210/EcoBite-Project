<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartnerLogo;

class PartnerLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing partner logos
        PartnerLogo::truncate();

        // Partner logos data from the original hardcoded array
        $partnerLogos = [
            ['name' => 'Walmart', 'logo' => 'images/vendors/walmart.png'],
            ['name' => 'Target', 'logo' => 'images/vendors/target.png'],
            ['name' => 'Burger King', 'logo' => 'images/vendors/burgerking.png'],
            ['name' => 'KFC', 'logo' => 'images/vendors/kfc.png'],
            ['name' => 'McDonald\'s', 'logo' => 'images/vendors/mcdonalds.png'],
            ['name' => 'Subway', 'logo' => 'images/vendors/subway.png'],
            ['name' => 'CVS', 'logo' => 'images/vendors/cvs.png'],
            ['name' => 'Bloom Bask', 'logo' => 'images/vendors/bloombask.png'],
            ['name' => 'Auto Revive Garage', 'logo' => 'images/vendors/autorevivegarage.png'],
            ['name' => 'Byte Medic', 'logo' => 'images/vendors/bytemedic.png'],
            ['name' => 'Glow Grace Studio', 'logo' => 'images/vendors/glowgracestudio.png'],
            ['name' => 'Handy Hive', 'logo' => 'images/vendors/handyhive.png'],
            ['name' => 'Hype Lane', 'logo' => 'images/vendors/hypelane.png'],
            ['name' => 'Plug & Play Installations', 'logo' => 'images/vendors/plug&playinstallations.png'],
        ];

        // Create partner logos in database
        foreach ($partnerLogos as $index => $logo) {
            $partnerLogo = PartnerLogo::create([
                'name' => $logo['name'],
                'is_active' => true,
                'in_order' => $index + 1,
            ]);

            // Add media if the logo file exists
            $logoPath = public_path($logo['logo']);
            if (file_exists($logoPath)) {
                try {
                    $partnerLogo->addMedia($logoPath)
                        ->preservingOriginal()
                        ->toMediaCollection();
                } catch (\Exception $e) {
                    // If media library fails, just skip
                    \Log::warning("Could not add media for partner logo: {$logo['name']}. Error: " . $e->getMessage());
                }
            }
        }

        $this->command->info('Partner logos seeded successfully!');
    }
}

