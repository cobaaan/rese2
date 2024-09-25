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
            'user_id' => 2,
            'shop_id' => 1,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 2,
            'shop_id' => 2,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 2,
            'shop_id' => 3,
            'rate' => 2,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 2,
            'shop_id' => 4,
            'rate' => 4,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 2,
            'shop_id' => 5,
            'rate' => 3,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 6,
            'rate' => 5,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 7,
            'rate' => 4,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 8,
            'rate' => 3,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 9,
            'rate' => 2,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 3,
            'shop_id' => 10,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 4,
            'shop_id' => 11,
            'rate' => 3,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 4,
            'shop_id' => 12,
            'rate' => 5,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 4,
            'shop_id' => 13,
            'rate' => 4,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 4,
            'shop_id' => 14,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 4,
            'shop_id' => 15,
            'rate' => 3,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 5,
            'shop_id' => 16,
            'rate' => 2,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 5,
            'shop_id' => 17,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 5,
            'shop_id' => 18,
            'rate' => 4,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 5,
            'shop_id' => 19,
            'rate' => 1,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
        
        $param = [
            'user_id' => 5,
            'shop_id' => 20,
            'rate' => 3,
            'comment' => '宗像 穴子御膳・ 博多曲げ物 前菜盛り合わせ・ 土鍋ごはん アナゴ・ 魚の餡かけ アマダイ・ 香の物・ 薬味・ 〆のお茶漬け・ デザートと黒豆茶クリスマスだし、銀シャリの土鍋ごはんと明太子を食べようと思った。',
            'image_path' => 'image/ramen.jpg'
        ];
        DB::table('reviews')->insert($param);
    }
}
