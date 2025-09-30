<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\DataProviders\CountryStateCityDataProvider;
use Illuminate\Support\Facades\DB;

class CountryStateCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        Country::insert(CountryStateCityDataProvider::Countries());

        State::insert(CountryStateCityDataProvider::States());
        */

        // foreach (collect(CountryStateCityDataProvider::Cities())->chunk(15000) as $chunkCities){
        //     City::insert($chunkCities->toArray());
        // }
        Country::insertOrIgnore(CountryStateCityDataProvider::Countries());
        State::insertOrIgnore(CountryStateCityDataProvider::States());
        foreach (collect(CountryStateCityDataProvider::Cities())->chunk(15000) as $chunkCities) {
            City::insertOrIgnore($chunkCities->toArray());
        }
        DB::table('states')->update(['is_active' => 0]);
        DB::table('cities')->update(['is_active' => 0]);
    }
}
