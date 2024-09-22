<?php

use Illuminate\Database\Seeder;
use App\Models\Seo;

class SEOSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [ 
					['slug' => 'home'],
					['slug' => 'about-us'],
					['slug' => 'contact_us'],
					['slug' => 'crypto-tracking'],
					['slug' => 'pricing'],
					['slug' => 'search'],
					['slug' => 'threat-map'],
					['slug' => 'blockchain-search-history'],
					['slug' => 'search-history'],
                    // workspace
                    // crypto-analysis
                    // favorites
                    // investigation
                    // alerts

                    ];

      foreach ($data as $key => $value) {
        
        if(Seo::where('slug',$value['slug'])->count()>0){
         // Seo::where('slug',$value['slug'])->update($data[$key]);
        }else{
            
           Seo::insert($data[$key]);

        }
      }
    }
}
