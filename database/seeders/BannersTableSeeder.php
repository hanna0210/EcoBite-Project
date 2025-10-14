<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('banners')->delete();

        // Create home banners using local images
        $homeBannerPath = public_path('images/home_banner');
        
        if (File::exists($homeBannerPath)) {
            $bannerImages = [
                'home_banner1.png',
                'home_banner2.png',
                'home_banner3.png',
            ];

            foreach ($bannerImages as $index => $imageName) {
                $imagePath = $homeBannerPath . '/' . $imageName;
                
                if (File::exists($imagePath)) {
                    $banner = new Banner();
                    $banner->link = '#'; // Default link, can be updated from admin panel
                    $banner->vendor_type_id = null; // Home page banner
                    $banner->featured = true;
                    $banner->is_active = true;
                    $banner->in_order = $index + 1;
                    $banner->save();
                    
                    // Add the image to the banner
                    $banner->clearMediaCollection();
                    $banner->addMedia($imagePath)->preservingOriginal()->toMediaCollection();
                }
            }
        }
    }
}
