<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Manager;

class ManagersTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $param = [
            'name' => '北大路欣也',
            'email' => 'kitaouji@kinkin.example',
            'password' => Hash::make('password'),
        ];
        DB::table('managers')->insert($param);
        
        $param = [
            'name' => '杉良太郎',
            'email' => 'r.sugi@osugi.example',
            'password' => Hash::make('password'),
        ];
        DB::table('managers')->insert($param);
        
        Manager::factory()->count(1)->create();
    }
}
