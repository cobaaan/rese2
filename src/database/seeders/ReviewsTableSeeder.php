<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Review;

class ReviewsTableSeeder extends Seeder
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
            'shop_id' => 2,
            'reserve_id' => 1,
            'rate' => 4,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
        ];
        DB::table('reviews')->insert($param);
        
        Review::factory()->count(100)->create();
    }
}
