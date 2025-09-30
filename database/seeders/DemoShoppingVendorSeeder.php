<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorType;
use App\Traits\ImageGeneratorTrait;
use App\Traits\MediaModelConnectorTrait;
use Illuminate\Database\Seeder;

class DemoShoppingVendorSeeder extends Seeder
{
    use ImageGeneratorTrait, MediaModelConnectorTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $vendorTypeId = VendorType::where('slug', 'commerce')->first()->id;
        //delete all vendors with food type
        // $vendorIds = Vendor::where('vendor_type_id', $vendorTypeId)->pluck('id')->toArray();
        // Product::whereIn('vendor_id', $vendorIds)->delete();
        // Vendor::where('vendor_type_id', $vendorTypeId)->delete();


        //
        //
        $vendorNames = ['BloomBask', 'HypeLane'];
        //short descriptions
        $vendorDecriptions = [
            "BloomBask is your go-to destination for sustainable living. We offer eco-conscious products that blend beauty, utility, and responsibility—perfect for the modern, mindful shopper.",
            "HypeLane is where street style meets the hype. We curate limited-edition drops, exclusive apparel, and high-demand kicks for trendsetters who live at the cutting edge of fashion."
        ];

        //array of best selling products from each vendor, name: description
        $vendorProducts = [

            [
                [
                    "name" => "Reusable Bamboo Kitchen Towels",
                    "description" => "Reusable Bamboo Kitchen Towels – Washable, biodegradable, and absorbent.",
                ],
                [
                    "name" => "Soy Wax Scented Candle – Lavender Fields",
                    "description" => "🕯 Soy Wax Scented Candle – Lavender Fields – Clean-burning and toxin-free",
                ],
                [
                    "name" => "Organic Cotton Mesh Grocery Bags",
                    "description" => "Organic Cotton Mesh Grocery Bags – Perfect for produce and bulk shopping",
                ],
                [
                    "name" => "Glass Water Bottle with Silicone Sleeve",
                    "description" => "💧 Glass Water Bottle with Silicone Sleeve – Stylish hydration without the plastic.",
                ],
                [
                    "name" => "Mini Herb Grow Kit (Basil & Mint) ",
                    "description" => "🌱 Mini Herb Grow Kit (Basil & Mint) – Grow your own herbs at home with ease.",
                ],
            ],
            //
            [
                [
                    "name" => "Yeezy Boost 350 V2 – Onyx",
                    "description" => "🔥 Yeezy Boost 350 V2 – Onyx – Sleek, rare, and ultra-comfortable.",
                ],
                [
                    "name" => "Supreme Box Logo Cap – Black",
                    "description" => "🧢 Supreme Box Logo Cap – Black – A bold staple for your street fit.",
                ],
                [
                    "name" => "Off-White Oversized Denim Jacket",
                    "description" => "🧥 Off-White Oversized Denim Jacket – Designer edge with urban vibes.",
                ],
                [
                    "name" => "Nike Air Jordan 1 Retro High OG – UNC",
                    "description" => "👟 Nike Air Jordan 1 Retro High OG – UNC – An icon reborn in classic blue.",
                ],
                [
                    "name" => "HypeLane Limited Sneaker Storage Box",
                    "description" => "💼 HypeLane Limited Sneaker Storage Box – Stackable, UV-protected, sneakerhead essential",
                ],
            ],
        ];
        //
        $faker = \Faker\Factory::create();
        //Loop through the vendor names
        foreach ($vendorNames as $key => $vendorName) {
            $model = new Vendor();
            $model->name = $vendorName;
            $model->description = $vendorDecriptions[$key];
            $model->delivery_fee = $faker->randomNumber(2, false);
            $model->delivery_range = 40075;
            $model->tax = rand(0, 50);
            $model->phone = $faker->phoneNumber;
            $model->email = $faker->email;
            $model->address = $faker->address;
            $model->latitude = $faker->latitude();
            $model->longitude = $faker->longitude();
            $model->tax = rand(0, 1);
            $model->pickup = 1;
            $model->delivery = 1;
            $model->is_active = 1;
            $model->vendor_type_id = $vendorTypeId;
            $model->saveQuietly();
            //logo gen
            try {
                $this->setVendorImages($model);
            } catch (\Exception $ex) {
                logger("Error", [$ex->getMessage()]);
            }

            //add product
            $vendorProductList = $vendorProducts[$key];
            foreach ($vendorProductList as $vendorProductData) {
                $product = new Product();
                $product->name = $vendorProductData['name'];
                $product->description = $vendorProductData['description'];
                $product->price = $faker->randomNumber(4, false);
                $product->is_active = 1;
                $product->deliverable = rand(0, 1);
                $product->featured = rand(0, 1);
                $product->vendor_id = $model->id;
                $product->saveQuietly();
                $product->approved = true;
                $product->saveQuietly();
                //
                try {
                    $this->setProductImages($product);
                } catch (\Exception $ex) {
                    logger("Error", [$ex->getMessage()]);
                }
            }
        }
    }
}