<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ReseController;

use App\Http\Requests\ShopRequest;

use App\Models\Favorite;
use App\Models\Reserve;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;

use Auth;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ShopController extends Controller
{
    /*
    public function test() {
        $dt = Carbon::now()->toDateString();
        
        $reserves = DB::table('reserves')
        ->where('date', $dt)
        ->get();
        
        foreach($reserves as $reserve) {
            $user = DB::table('users')
            ->where('id', $reserve->user_id)
            ->select('name', 'email')
            ->first();
            
            $shopName = DB::table('shops')
            ->where('id', $reserve->shop_id)
            ->select('name')
            ->first();
            
            Mail::send([], [], function ($message) use ($user, $shopName, $reserve){
                $message->to($user->email)
                ->subject('<Rese>本日ご来店予約のお知らせ')
                ->setBody($user->name . ' 様' . "\n" .
                "\n" .
                '本日 ' . substr($reserve->time, 0, 5) . ' より、' . $reserve->number . ' 名様でのご来店予定となっております。' . "\n" .
                '従業員一同、心よりお待ちいたしております。' . "\n" .
                "\n" .
                'こちら配信専用メールとなっております。' . "\n" .
                '店舗への連絡は直接店舗の方へよろしくお願い致します。' . "\n" .
                "\n" .
                'Rese');
            });
        }
    }
    */
    public function shopAll() {
        $auth = Auth::user();
        $shops = Shop::all();
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        
        $favorites = Favorite::all();
        
        $averageRatings = ReseController::reviewStar();
        return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'auth', 'averageRatings'));
        /*
        if(isset($auth)){
            return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'auth', 'averageRatings'));
        } else {
            return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'averageRatings'));
        }
        */
    }
    
    public function shopDetail(Request $request) {
        $shopModal = null;
        
        $requests = $request->all();
        $dt = Carbon::now();
        $auth = Auth::user();
        //$auths = Auth::user();
        
        $averageRatings = ReseController::reviewStar();
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
        /*
        if(isset($auths)){
            $auth = $auths->id;
            return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
        } else {
            return view('shop_detail', compact('requests', 'dt', 'user', 'reviews', 'averageRatings', 'shopModal'));
        }
        */   
    }
    
    public function modal(Request $request) {
        $shopModal = 'set';
        
        $requests = $request->all();
        $dt = Carbon::now();
        //$auths = Auth::user();
        $auth = Auth::user();
        
        
        $averageRatings = ReseController::reviewStar();
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
        
        /*
        if(isset($auths)){
            $auth = $auths->id;
            return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
        } else {
            return view('shop_detail', compact('requests', 'dt', 'user', 'reviews', 'averageRatings', 'shopModal'));
        }
        */
    }
    
    public function shopCreate(Request $request) {
        $requests = $request->all();
        
        $dir = 'image';
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        
        $params = [
            'user_id' => $request['user_id'],
            'name' => $requests['name'],
            'area' => $requests['area'],
            'genre' => $requests['genre'],
            'description' => $requests['description'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        
        Shop::create($params);
        
        return view('thanks_shop_create');
    }
    
    public function shopManager() {
        $auth = Auth::user();
        $shop = DB::table('shops')
        ->where('user_id', $auth->id)
        ->first();
        
        return view('shop_manager', compact('auth', 'shop'));
    }
    
    public function shopReserve() {
        $auth = Auth::user();
        $users = User::all();
        
        $shop = DB::table('shops')
        ->where('user_id', $auth->id)
        ->first();
        
        $reserves = DB::table('reserves')
        ->where('shop_id', $shop->id)
        ->get();
        
        $currentDate = Carbon::now()->toDateString();
        
        $pastReserves = [];
        $todayReserves = [];
        $futureReserves = [];
        
        foreach ($reserves as $reserve) {
            $reserveDate = Carbon::parse($reserve->date);
            
            if ($reserveDate->lt($currentDate)) {
                $pastReserves[] = $reserve;
            } elseif ($reserveDate->eq($currentDate)) {
                $todayReserves[] = $reserve;
            } else {
                $futureReserves[] = $reserve;
            }
        }
        
        return view('shop_reserve', compact('users', 'shop', 'pastReserves', 'todayReserves', 'futureReserves', 'auth'));
    }
    
    public function shopUpdate(ShopRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        
        $dir = 'image';
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        
        $shops = DB::table('shops')
        ->where('id', $requests['shop_id'])
        ->first();
        
        $params = [
            'name' => $requests['name'],
            'area' => $requests['area'],
            'genre' => $requests['genre'],
            'description' => $requests['description'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        $nonNull = array_filter($params, function ($value) {
            return $value !== null;
        });
        
        Shop::where('id', $requests['shop_id'])->update($nonNull);
        
        return view('thanks_shop_create', compact('auth'));
    }
}
