<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Shop;
use App\Models\User;
use App\Models\Reserve;
use App\Models\Favorite;

use Auth;

use Carbon\Carbon;

class ReseController extends Controller
{
    public function review(Request $request) {
        $requests = $request->all();
        $dt = Carbon::now();
        $auth = Auth::user();
        $auth = $auth->id;
        
        return view('review', compact('requests', 'dt', 'auth'));
    }
    
    public function verify() {
        return view('auth/verify');
    }
    
    public function updateReserve(Request $request) {
        $requests = $request->all();
        
        $param = [
            'date' => $requests['date'],
            'time' => $requests['time'],
            'number' => $requests['number'],
        ];
        
        Reserve::where('id', $requests['id'])->update($param);
        
        return view('done');
    }
    
    public function changeReserve(Request $request) {
        $auth = Auth::user();
        $dt = Carbon::now();
        $requests = $request->all();
        $shops = Shop::all();
        
        $reserves = DB::table('reserves')
        ->where('id', $request->id)
        ->get();
        
        return view ('change_reserve', compact('requests', 'reserves', 'shops', 'auth', 'dt'));
    }
    
    public function toggleFavorite($id)
    {
        $favorite = Favorite::where('user_id', auth()->id())
        ->where('shop_id', $id)
        ->first();
        
        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'shop_id' => $id,
            ]);
        }
        
        return back();
    }
    
    
    public function search(Request $request) {
        $query = Shop::query();
        $query = $this->getSearchQuery($request, $query);
        
        $shops = $query->get();
        
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        
        return view('shopAll', compact('shops', 'shopAreas', 'shopGenres'));
    }
    
    public function getSearchQuery($request, $query) {
        if(!empty($request->text)) {
            $query->where('name', 'like', '%' . $request->text . '%');
        };
        
        if (!empty($request->area)) {
            $query->where('area', '=', $request->area);
        }
        
        if (!empty($request->genre)) {
            $query->where('genre', '=', $request->genre);
        }
        
        return $query;
    }
    
    public function favorite() {
        
    }
    
    public function cancel(Request $request) {
        $requests = $request->all();
        Reserve::find($request->id)->delete();
        
        $auths = Auth::user();
        $shops = Shop::all();
        
        $reserves = DB::table('reserves')
        ->where('user_id', $auths->id)
        ->get();
        
        $favorites = DB::table('favorites')
        ->where('user_id', $auths->id)
        ->get();
        
        return view('myPage', compact('reserves', 'shops', 'favorites', 'auths'));
    }
    
    public function menu() {
        if(Auth::check()) {
            return view('menu1');
        }
        else {
            return view('menu2');
        }
    }
    
    public function done (){
        return view('done');
    }
    public function thanks (){
        return view('thanks');
    }
    
    
    
    public function reserve(Request $request) {
        $requests = $request->all();
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'date' => $requests['date'],
            'time' => $requests['time'],
            'number' => $requests['number'],
        ];
        Reserve::create($param);
        
        return view('done');
    }
    
    public function myPage() {
        $auth = Auth::user();
        $shops = Shop::all();
        $dt = Carbon::now();
        
        $reserves = DB::table('reserves')
        ->where('user_id', $auth->id)
        ->get();
        
        $pastReservations = [];
        $futureReservations = [];
        
        foreach($reserves as $reserve) {
            $visitDateTime = Carbon::parse($reserve->date . ' ' . $reserve->time);
            if($visitDateTime->isPast()) {
                $pastReservations[] = $reserve;
            } else {
                $futureReservations[] = $reserve;
            }
        }
        
        $favorites = DB::table('favorites')
        ->where('user_id', $auth->id)
        ->get();
        
        return view('my_page', compact('pastReservations', 'futureReservations', 'shops', 'favorites', 'auth'));
    }
    
    
    public function toggleFavoriteMyPage($id)
    {
        $favorite = Favorite::where('user_id', auth()->id())
        ->where('shop_id', $id)
        ->first();
        
        if ($favorite) {
            $favorite->delete();
        } else {
            Favorite::create([
                'user_id' => auth()->id(),
                'shop_id' => $id,
            ]);
        }
        
        return back();
    }
    
    public function shopDetail(Request $request) {
        $requests = $request->all();
        $dt = Carbon::now();
        $auths = Auth::user();
        $auth = $auths->id;
        
        return view('shop_detail', compact('requests', 'dt', 'auth'));
    }
    
    public function shopAll() {
        $auths = Auth::user();
        $shops = Shop::all();
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        
        $favorites = Favorite::all();
        
        return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'auths'));
    }
}
