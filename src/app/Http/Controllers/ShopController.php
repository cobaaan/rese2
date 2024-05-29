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
    public function shopAll() {
        $auth = Auth::user();
        $shops = Shop::all();
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        
        $favorites = Favorite::all();
        
        $averageRatings = ReseController::reviewStar();
        return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'auth', 'averageRatings'));
    }
    
    public function shopDetail(Request $request) {
        $shopModal = null;
        
        $requests = $request->all();
        $dt = Carbon::now();
        $auth = Auth::user();
        
        $averageRatings = ReseController::reviewStar();
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        
        return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
    }
    
    public function modal(Request $request) {
        $shopModal = 'set';
        
        $requests = $request->all();
        $dt = Carbon::now();
        $auth = Auth::user();
        
        
        $averageRatings = ReseController::reviewStar();
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        
        return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
    }
    
    public function shopCreate(ShopRequest $request) {
        $auth = Auth::user();
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
        
        return view('thanks', compact('auth'))->with('massage', '店舗登録ありがとうございます。');
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
        
        $shop = Shop::where('user_id', $auth->id)->first();
        
        if (isset($shop)) {
            $reserves = Reserve::where('shop_id', $shop->id)->with('user')->get();
            
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
        
        return view('shop_reserve', compact('users', 'shop', 'auth'));
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
        
        return view('thanks', compact('auth'))->with('massage', '店舗情報の変更をしました。');
    }
    
    public function visit(Request $request) {
        $auth = Auth::user();
        $id = $request->id;
        
        return view('visit', compact('auth', 'id'));
    }
    
    public function visited(Request $request) {
        $auth = Auth::user();
        
        Reserve::where('id', $request['id'])->update(['is_visit' => 1]);
        
        return view('thanks', compact('auth'))->with('massage', '来店済みに変更しました。');
    }
}
