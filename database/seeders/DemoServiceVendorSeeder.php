<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use App\Models\Vendor;
use App\Models\VendorType;
use App\Traits\ImageGeneratorTrait;
use App\Traits\MediaModelConnectorTrait;
use Illuminate\Database\Seeder;

class DemoServiceVendorSeeder extends Seeder
{

    use ImageGeneratorTrait, MediaModelConnectorTrait;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //
        $vendorTypeId = VendorType::where('slug',  'service')->first()->id;


        //cretae category
        $category = Category::firstOrCreate([
            'vendor_type_id' => $vendorTypeId,
        ], [
            'name' => 'General',
            'is_active' => 1,
        ]);

        //create subcategory
        $subcategory = Subcategory::firstOrCreate([
            'category_id' => $category->id,
        ], [
            'name' => 'General',
            'is_active' => 1,
        ]);

        //delete all vendors with food type
        // $vendorIds = Vendor::where('vendor_type_id', $vendorTypeId)->pluck('id')->toArray();
        // Vendor::where('vendor_type_id', $vendorTypeId)->delete();
        //delete all products
        // Service::whereIn('vendor_id', $vendorIds)->delete();


        //
        $faker = \Faker\Factory::create();

        $vendorNames = [
            $faker->company,
            $faker->company,
            $faker->company,
            $faker->company,
            $faker->company,
        ];
        //array of services: e.g Painting, Moving, Cleaning
        $vendorServices = [
            [
                "Diagnose & Software Checkup",
                "Virus & Spyware Removal",
                "Data Recovery",
            ],
            [
                "Engine & Oil , Filter Change",
                "Brake Pads & Rotors Replacement",
            ],
            [
                "Bridal Makeover",
                "Massage Therapy",
            ],
            [
                "Plumbing",
                "Electrical Repair",
                "Carpentry",
                "Painting",
                "Furniture Assembly",
                "Home Cleaning",
            ],
            [
                "Cable TV Installation",
                "Air Conditioner Installation",
                "Home Theater Installation",
                "Home Security System Installation",
            ]
        ];
        //
        $vendorNames = [
            "ByteMedic",
            "AutoRevive Garage",
            "Glow Grace Studio",
            "HandyHive",
            "Plug & Play Installations"
        ];
        $vendorDescriptions = [
            "ByteMedic specializes in computer diagnostics, virus removal, and data recovery. Whether it’s a sluggish system, harmful malware, or lost files, ByteMedic delivers fast, secure, and expert-level tech support to get your devices healthy again.",
            "AutoRevive Garage brings expert care to your vehicle with professional oil and filter changes, brake replacements, and general maintenance. Our certified mechanics ensure your car runs smoothly, safely, and efficiently—reviving your ride with every visit.",
            "Glow Grace Studio is your destination for radiant bridal makeovers and rejuvenating massage therapy. We combine beauty and wellness in a serene environment, helping you look and feel your best for your special day and beyond.",
            "HandyHive is your all-in-one solution for home maintenance, offering top-quality plumbing, electrical repair, carpentry, painting, cleaning, and more. Reliable, skilled, and always on time—your hive of handy help is just a call away.",
            "Plug & Play Installations makes smart living simple with expert installation of cable TV, air conditioners, home theaters, and security systems. Seamless setup, clean finishes, and hassle-free service—just plug in and enjoy."
        ];

        //Loop through the vendor names
        foreach ($vendorNames as $key => $vendorName) {
            $model = new Vendor();
            $model->name = $vendorName;
            $model->description = $vendorDescriptions[$key];
            $model->delivery_fee = rand(5, 600);
            $model->delivery_range = 40075;
            $phoneNumber = $faker->phoneNumber;
            $phoneNumber = preg_replace('/[^\d+]/', '', $phoneNumber);
            $model->phone = $phoneNumber;
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
            $vendorServiceList = $vendorServices[$key];
            foreach ($vendorServiceList as $vendorServiceName) {
                $service = new Service();
                $service->name = $vendorServiceName;
                $service->description = "";
                $service->price = rand(10, 250);
                $service->is_active = 1;
                $service->duration = "fixed";
                $service->vendor_id = $model->id;
                $service->category_id = $category->id;
                $service->subcategory_id = $subcategory->id;
                $service->saveQuietly();
                //
                try {
                    $this->setProductImages($service);
                } catch (\Exception $ex) {
                    logger("Error", [$ex->getMessage()]);
                }
            }
        }
    }
}
