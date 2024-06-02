<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MailRequest;
use App\Http\Requests\ShopRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReserveRequest;

use Illuminate\Support\Facades\DB;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
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
        $showModal = null;
        $auth = Auth::user();
        $shops = Shop::all();
        $areas = Area::all();
        
        $favorites = Favorite::where('user_id', $auth->id)
        ->with('shop.area', 'shop.genre')
        ->get();
        
        $futureReservations = Reserve::where('user_id', $auth->id)
        ->where('is_visit', 0)
        ->with('shop')
        ->get();
        
        $pastReservations = Reserve::where('user_id', $auth->id)
        ->where('is_visit', 1)
        ->with('shop')
        ->get();
        
        return view('my_page', compact('pastReservations', 'futureReservations', 'shops', 'favorites', 'auth', 'showModal'));
    }
    
    public function modal() {
        $showModal = 'show';
        $auth = Auth::user();
        $shops = Shop::all();
        
        $favorites = Favorite::where('user_id', $auth->id)
        ->with('shop')
        ->get();
        
        $futureReservations = Reserve::where('user_id', $auth->id)
        ->where('is_visit', 0)
        ->with('shop')
        ->get();
        
        $pastReservations = Reserve::where('user_id', $auth->id)
        ->where('is_visit', 1)
        ->with('shop')
        ->get();
        
        return view('my_page', compact('pastReservations', 'futureReservations', 'shops', 'favorites', 'auth', 'showModal'));
    }
    
    public function done (){
        $auth = Auth::user();
        
        return view('done', compact('auth'));
    }
    
    public function thanks (){
        $auth = Auth::user();
        
        return view('thanks', compact('auth'))->with('massage', '会員登録ありがとうございます。');
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
}
