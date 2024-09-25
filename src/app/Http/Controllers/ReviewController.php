<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReviewUpdateRequest;

use App\Models\Favorite;
use App\Models\Shop;
use App\Models\Reserve;
use App\Models\Review;

use Auth;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $request) {
        $auth = Auth::user();
        
        $shop = Shop::where('id', $request->shop_id)
        ->first();
        
        $favorites = Favorite::all();
        
        $review = Review::where('user_id', $auth->id)
        ->where('shop_id', $request->shop_id)
        ->first();
        
        if(!is_null($review)) {
            return view('review', compact('shop', 'auth', 'favorites', 'review'));
        } else {
            return view('review', compact('shop', 'auth', 'favorites'));
        }
    }
    
    public function reviewPost(ReviewRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        
        $dir = 'image';
        
        if (!empty($request->file('image_path'))) {
            $file_name = $request->file('image_path')->getClientOriginalName();
            $request->file('image_path')->storeAs('public/' . $dir, $file_name);
        } else {
            $file_name = $request->input('existing_image_path');
        }
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'rate' => $requests['rate'],
            'comment' => $requests['comment'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        
        Review::create($param);
        
        return view('thanks', compact('auth'))->with('message', 'レビュー投稿ありがとうございます。')->with('message1', 'ホーム');
    }
    
    public function reviewUpdate(ReviewUpdateRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        
        $dir = 'image';
        
        if (!empty($request->file('image_path'))) {
            $file_name = $request->file('image_path')->getClientOriginalName();
            $request->file('image_path')->storeAs('public/' . $dir, $file_name);
        } else {
            $file_name = $request->input('existing_image_path');
        }
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'rate' => $requests['rate'],
            'comment' => $requests['comment'],
            'image_path' => 'storage/' . $dir . '/' . $file_name,
        ];
        
        Review::where('user_id', $auth->id)
        ->where('shop_id', $requests['shop_id'])
        ->update($param);
        
        return view('thanks', compact('auth'))->with('message', 'レビュー投稿ありがとうございます。')->with('message1', 'ホーム');
    }
    
    public function reviewDelete(Request $request) {
        $requests = $request->all();
        $auth = Auth::user();
        Review::where('user_id', $auth->id)
        ->where('shop_id', $requests['shop_id'])
        ->delete();
        
        return view('thanks', compact('auth'))->with('message', 'レビューを削除しました。')->with('message1', 'ホーム');
    }
    
    public function reviewList() {
        $reviews = Review::all();
        
        return view('reviewList', compact('reviews'));
    }
    
    public function reviewDeleteAdmin(Request $request) {
        $requests = $request->all();
        Review::where('id', $requests['id'])
        ->delete();
        
        return view('thanks')->with('message', 'レビューを削除しました。')->with('message1', 'ホーム');
    }
}
