<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = User::where('email', 'super-admin@gmail.com')->first();
        if(!$super_admin){
            User::Create([
                'name' => 'Super Admin',
                'username' => 'super-admin',
                'email' => 'super-admin@gmail.com',
                'password' => Hash::make('12345678'),
                'is_admin' => 'Y',
                'is_active' => 'Y'
            ]);
        }
    }
}
