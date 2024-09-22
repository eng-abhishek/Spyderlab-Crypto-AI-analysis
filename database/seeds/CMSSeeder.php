<?php

use Illuminate\Database\Seeder;
use App\Models\Cms;

class CMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
    $data = [
                    ['slug' => 'about-us'],
					['slug' => 'privacy-policy'],
					['slug' => 'terms-condition'],

                ];

      foreach ($data as $key => $value) {
        
        if(Cms::where('slug',$value['slug'])->count()>0){
         // Seo::where('slug',$value['slug'])->update($data[$key]);
        }else{
            
           Cms::insert($data[$key]);

        }
      }
    }
}
