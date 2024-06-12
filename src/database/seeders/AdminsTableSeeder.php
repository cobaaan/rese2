<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $param = [
            'name' => '高倉健',
            'email' => 'k.takakura@poppoya.example',
            'password' => Hash::make('password'),
        ];
        DB::table('admins')->insert($param);
    }
}
