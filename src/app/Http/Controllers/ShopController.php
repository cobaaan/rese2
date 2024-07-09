<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ReseController;

use App\Http\Requests\ShopRequest;

use App\Models\Favorite;
use App\Models\Reserve;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;

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
        $areas = Area::all();
        $genres = Genre::all();
        
        $favorites = Favorite::all();
        
        $averageRatings = ReseController::reviewStar();
        
        return view('shop_all', compact('shops', 'areas', 'genres', 'favorites', 'auth', 'averageRatings'));
    }
    
    public function shopDetail(Request $request) {
        $shopModal = null;
        
        $requests = $request->all();
        $dt = Carbon::now();
        $auth = Auth::user();
        
        $averageRatings = ReseController::reviewStar();
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        
        if(empty($requests)) {
            return redirect('/');
            
        }
        else {
            return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal'));
        }
    }
    
    public function shopCreate(ShopRequest $request) {
        $auth = Auth::user();
        $requests = $request->all();
        
        $dir = 'image';
        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/' . $dir, $file_name);
        
        $areaGenre = ShopController::areaGenreGet($requests);
        
        $params = [
            'manager_id' => $request['manager_id'],
            'name' => $requests['name'],
            'area_id' => $areaGenre['area'],
            'genre_id' => $areaGenre['genre'],
            'description' => $requests['description'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        
        Shop::create($params);
        
        return view('thanks', compact('auth'))->with('message', '店舗登録ありがとうございます。')->with('message1', 'ホーム');
    }
    
    public function shopManager() {
        $auth = Auth::user();
        
        $shop = Shop::where('manager_id', $auth->id)
        ->with('area', 'genre')
        ->first();
        
        return view('shop_manager', compact('auth', 'shop'));
    }
    
    public function shopReserve() {
        $auth = Auth::user();
        $users = User::all();
        
        $shop = Shop::where('manager_id', $auth->id)->first();
        
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
    
    public function areaGenreGet($requests) {
        $area = DB::table('areas')
        ->where('area', $requests['area'])
        ->first();
        
        if($area === null){
            $params = [
                'area' => $requests['area'],
            ];
            
            $newArea = Area::create($params);
            $areaId = $newArea->id;
            
        } else {
            $areaId = $area->id;
        }
        
        $genre = DB::table('genres')
        ->where('genre', $requests['genre'])
        ->first();
        
        if($genre === null){
            $params = [
                'genre' => $requests['genre'],
            ];
            
            $newGenre = Genre::create($params);
            $genreId = $newGenre->id;
            
        } else {
            $genreId = $genre->id;
        }
        
        $params = [
            'area' => $areaId,
            'genre' => $genreId
        ];
        return($params);
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
        
        $areaGenre = ShopController::areaGenreGet($requests);
        
        $params = [
            'name' => $requests['name'],
            'area_id' => $areaGenre['area'],
            'genre_id' => $areaGenre['genre'],
            'description' => $requests['description'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        $nonNull = array_filter($params, function ($value) {
            return $value !== null;
        });
        
        Shop::where('id', $requests['shop_id'])->update($nonNull);
        
        return view('thanks', compact('auth'))->with('message', '店舗情報の変更をしました。')->with('message1', 'ホーム');
    }
    
    public function visit(Request $request) {
        $auth = Auth::user();
        $id = $request->id;
        
        return view('visit', compact('auth', 'id'));
    }
    
    public function visited(Request $request) {
        $auth = Auth::user();
        
        Reserve::where('id', $request['id'])->update(['is_visit' => 1]);
        
        return view('thanks', compact('auth'))->with('message', '来店済みに変更しました。')->with('message1', 'ホーム');
    }
}
