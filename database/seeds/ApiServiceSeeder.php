<?php

use Illuminate\Database\Seeder;
use App\Models\ApiService;

class ApiServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $api_services_arr = [
            [
                'name' => 'Truecaller',
                'slug' => 'truecaller'
            ],
            [
                'name' => 'Numverify',
                'slug' => 'numverify'
            ],
            [
                'name' => 'Facebook',
                'slug' => 'facebook'
            ],
            [
                'name' => 'Twitter',
                'slug' => 'twitter'
            ],
            [
                'name' => 'Have I Been Pwned',
                'slug' => 'have-i-been-pwned'
            ],
            [
                'name' => 'Whatsapp',
                'slug' => 'whatsapp'
            ],
            [
                'name' => 'Telegram',
                'slug' => 'telegram'
            ],
            [
                'name' => 'Chainsight',
                'slug' => 'chainsight'
            ],
            [
                'name' => 'Blockcypher',
                'slug' => 'blockcypher'
            ],
        ];

        foreach ($api_services_arr as $key => $value) {
            $api_service = ApiService::where('slug', $value['slug'])->first();

            if(!$api_service){
                ApiService::create([
                    'name' => $value['name'],
                    'slug' => $value['slug'],
                    'credentials' => null,
                    'created_at' => now()
                ]);
            }
        }
    }
}
