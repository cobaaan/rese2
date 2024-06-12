<?php

namespace App\Http\Controllers;

use Auth;

use App\Http\Requests\ReserveRequest;

use App\Models\Favorite;
use App\Models\Reserve;
use App\Models\Shop;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReserveController extends Controller
{
    public function reserve(ReserveRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        
        $time = sprintf('%02d:%02d:00', $requests['time'], $requests['minute']);
        
        $param = [
            'user_id' => $requests['user_id'],
            'shop_id' => $requests['shop_id'],
            'date' => $requests['date'],
            'time' => $time,
            'number' => $requests['number'],
            'is_visit' => 0,
        ];
        
        Reserve::create($param);
        
        return view('done', compact('auth'))->with('message', 'ご予約ありがとうございます。');
    }
    
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
        
        return view('done', compact('auth'))->with('message', 'ご予約をキャンセルしました。');
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
    
    public function updateReserve(ReserveRequest $request) {
        $requests = $request->all();
        $auth = Auth::user();
        $time = sprintf('%02d:%02d:00', $requests['time'], $requests['minute']);
        
        $param = [
            'date' => $requests['date'],
            'time' => $time,
            'number' => $requests['number'],
        ];
        
        Reserve::where('id', $requests['id'])->update($param);
        
        return view('done', compact('auth'))->with('message', 'ご予約の変更をしました。');
    }
}
