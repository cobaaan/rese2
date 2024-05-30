<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $param = [
            'user_id' => 3,
            'shop_id' => 6
        ];
        DB::table('favorites')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 12
        ];
        DB::table('favorites')->insert($param);
    }
}
