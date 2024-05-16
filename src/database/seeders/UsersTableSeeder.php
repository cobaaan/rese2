<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
            'role' => 'admin',
            'name' => '千葉真一',
            'email' => 'sunnychiba@samurai.example',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);
        
        $param = [
            'role' => 'shopManager',
            'name' => '北大路欣也',
            'email' => 'kitaouji@kinkin.example',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);
        
        $param = [
            'role' => 'user',
            'name' => '高倉健',
            'email' => 'k.takakura@poppoya.example',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ];
        DB::table('users')->insert($param);
    }
}
