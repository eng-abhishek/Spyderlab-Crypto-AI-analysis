<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SuperAdminSeeder::class,
            CountrySeeder::class,
            ApiServiceSeeder::class,
            SEOSeeder::class,
            CMSSeeder::class,
        ]);
    }
}
