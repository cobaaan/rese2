<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReserveRequest;

use Illuminate\Support\Facades\DB;

use App\Models\Shop;
use App\Models\User;
use App\Models\Reserve;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\Image;

use Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;

use Exception;

class ReseController extends Controller
{
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
    /*
    public function search(Request $request) {
        $auths = Auth::user();
        $query = Shop::query();
        $query = $this->getSearchQuery($request, $query);
        
        $shops = $query->get();
        
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        $favorites = Favorite::all();
        $averageRatings = $this->reviewStar();
        
        return view('shop_all', compact('auths', 'shops', 'shopAreas', 'shopGenres', 'favorites', 'averageRatings'));
    }
    */
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
    }    public function menu() {
        $auth = Auth::user();
        
        if(Auth::check()) {
            return view('menu1', compact('auth'));
        }
        else {
            return view('menu2', compact('auth'));
        }
    }
    
    public function done (){
        return view('done');
    }
    
    public function thanks (){
        return view('thanks');
    }
    
    public function reviewStar() {
        $shops = Shop::all();
        
        $averageRatings = [];
        
        foreach ($shops as $shop) {
            $averageRating = Review::where('shop_id', $shop->id)->avg('rate');
            
            $averageRating = $averageRating ?? 0;
            
            $averageRating = round($averageRating * 2) / 2;
            
            $averageRating = min(max($averageRating, 0.5), 5.0);
            
            if($averageRating < 1){
                $averageRatings[$shop->id] = 'star0';
            }
            else if($averageRating === 1.0) {
                $averageRatings[$shop->id] = 'star1';
            }
            else if($averageRating === 1.5) {
                $averageRatings[$shop->id] = 'star1-5';
            }
            else if($averageRating === 2.0) {
                $averageRatings[$shop->id] = 'star2';
            }
            else if($averageRating === 2.5) {
                $averageRatings[$shop->id] = 'star2-5';
            }
            else if($averageRating === 3.0) {
                $averageRatings[$shop->id] = 'star3';
            }
            else if($averageRating === 3.5) {
                $averageRatings[$shop->id] = 'star3-5';
            }
            else if($averageRating === 4.0) {
                $averageRatings[$shop->id] = 'star4';
            }
            else if($averageRating === 4.5) {
                $averageRatings[$shop->id] = 'star4-5';
            }
            else if($averageRating === 5.0) {
                $averageRatings[$shop->id] = 'star5';
            }
        }
        
        return $averageRatings;
    }
    /*
    public function userAll() {
        $users = User::all();
        
        return view('user_all', compact('users'));
    }
    */
    /*
    public function sendMail(MailRequest $request) {
        Mail::send([], [], function ($message) use ($request) {
            $message->to($request['email'])
            ->subject($request['subject'])
            ->setBody($request['body']);
        });
        
        return view('mail_sended');
    }
    
    public function mailForm(Request $request) {
        $requests = $request->all();
        unset($requests['_token']);
        
        return view('mail_form', compact('requests'));
    }
    */
    /*
    public function imageUpload($params, $requests) {
        $dir = $params['image'];
        
        $file_name = $requests->file($params['image'])->getClientOriginalName();
        
        $requests->file($params['image'])->storeAs('public/' . $dir, $file_name);
        
        $image = new Image();
        $image->user_id = $params['user_id'];
        $image->name = $file_name;
        $image->path = 'storage/' . $dir . '/' . $file_name;
        $image->save();
    }
    */
    /*
    public function shopUpdate(ShopRequest $request) {
        $requests = $request->all();
        
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
        
        //$this->imageUpload($params, $requests);
        
        return view('thanks_shop_create');
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
        
        return view('shop_reserve', compact('users', 'shop', 'pastReserves', 'todayReserves', 'futureReserves'));
    }
    */
    /*
    public function adminCreate(Request $request) {
        $requests = $request->all();
        $dt = Carbon::now();
        
        $user = User::create([
            'role' => $requests['role'],
            'name' => $requests['name'],
            'email' => $requests['email'],
            'password' => Hash::make($requests['password']),
        ]);
        return redirect()->back()->with('success');
    }
    */
    /*
    public function adminRegister() {
        return view('admin_register');
    }
    */
    /*
    public function reviewPost(ReviewRequest $request) {
        $requests = $request->all();
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'reserve_id' => $requests['reserve_id'],
            'rate' => $requests['rate'],
            'comment' => $requests['comment'],
        ];
        
        Review::create($param);
        
        return view('thanks_review');
    }
    
    public function review(Request $request) {
        $shops = Shop::all();
        $requests = $request->all();
        $reserves = Reserve::where('id', $requests['reserve_id'])->get();
        $auth = Auth::user();
        return view('review', compact('shops', 'requests', 'reserves', 'auth'));
    }
    */
    /*
    public function verify() {
        return view('auth/verify');
    }
    */
    /*
    public function updateReserve(ReserveRequest $request) {
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
    */
    /*
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
    */
    
    /*
    public function cancel(Request $request) {
        $requests = $request->all();
        Reserve::find($request->id)->delete();
        
        $auth = Auth::user();
        $shops = Shop::all();
        
        $reserves = DB::table('reserves')
        ->where('user_id', $auth->id)
        ->get();
        
        $favorites = DB::table('favorites')
        ->where('user_id', $auth->id)
        ->get();
        
        return redirect('my_page');
        //return view('my_page', compact('reserves', 'shops', 'favorites', 'auth'));
    }
    */
    
    
    
    /*
    public function reserve(ReserveRequest $request) {
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
    */
    
    /*
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
    */
    /*
    public function shopDetail(Request $request) {
        $requests = $request->all();
        $dt = Carbon::now();
        $auths = Auth::user();
        $auth = $auths->id;
        
        $user = User::all();
        
        $reviews = Review::where('shop_id', $request->id)->get();
        
        return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews'));
    }
    */
    /*
    public function shopAll() {
        $auths = Auth::user();
        $shops = Shop::all();
        $shopAreas = DB::select('SELECT DISTINCT area FROM shops');
        $shopGenres = DB::select('SELECT DISTINCT genre FROM shops');
        
        $favorites = Favorite::all();
        $averageRatings = $this->reviewStar();
        
        return view('shop_all', compact('shops', 'shopAreas', 'shopGenres', 'favorites', 'auths', 'averageRatings'));
    }
    */
    
}
