<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $param = [
            'name' => '千葉真一',
            'email' => 'sunnychiba@samurai.example',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);
        
        User::factory()->count(4)->create();
    }
}
