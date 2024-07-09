<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;

use App\Models\Shop;
use App\Models\Reserve;
use App\Models\Review;

use Auth;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function review(Request $request) {
        $shops = Shop::all();
        $requests = $request->all();
        $reserves = Reserve::where('id', $requests['reserve_id'])->with('shop')->get();
        $auth = Auth::user();
        
        return view('review', compact('shops', 'requests', 'reserves', 'auth'));
    }
    
    public function reviewPost(ReviewRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'rate' => $requests['rate'],
            'comment' => $requests['comment'],
        ];
        
        Review::create($param);
        
        return view('thanks', compact('auth'))->with('message', 'レビュー投稿ありがとうございます。')->with('message1', 'ホーム');
    }
}
