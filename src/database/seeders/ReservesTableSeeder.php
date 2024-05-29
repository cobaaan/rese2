<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservesTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'shop_id' => 6,
            'date' => '2024/04/28',
            'time' => '18:00:00',
            'number' => 3,
            'is_visit' => 0
        ];
        DB::table('reserves')->insert($param);
        
        $param = [
            'user_id' => 1,
            'shop_id' => 3,
            'date' => '2024/05/13',
            'time' => '18:00:00',
            'number' => 6,
            'is_visit' => 1
        ];
        DB::table('reserves')->insert($param);
    }
}
