<?php

namespace Database\Seeders;

use Carbon\Carbon;

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
        $dt = Carbon::now();
        
        $param = [
            'user_id' => 1,
            'shop_id' => 1,
            'date' => '2024/04/28',
            'time' => '19:00:00',
            'number' => 3,
            'is_visit' => 0
        ];
        DB::table('reserves')->insert($param);
        
        $param = [
            'user_id' => 1,
            'shop_id' => 1,
            'date' => '2024/10/13',
            'time' => '18:30:00',
            'number' => 6,
            'is_visit' => 1
        ];
        DB::table('reserves')->insert($param);
        
        $param = [
            'user_id' => 1,
            'shop_id' => 1,
            'date' => $dt->format('Y/m/d'),
            'time' => '20:30:00',
            'number' => 2,
            'is_visit' => 0
        ];
        DB::table('reserves')->insert($param);
    }
}
