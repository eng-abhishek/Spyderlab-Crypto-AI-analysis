<?php

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_path = database_path().'/seeds/data/countries.json';

        if(file_exists($file_path)){
            $countries_arr = json_decode(File::get($file_path), true);
            if($countries_arr){
                if(!Country::exists()){
                    Country::insert($countries_arr);
                }
            }
        }

    }
}
