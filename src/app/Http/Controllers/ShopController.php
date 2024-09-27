<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ReseController;

use App\Http\Requests\CsvRequest;
use App\Http\Requests\ShopRequest;

use App\Models\Favorite;
use App\Models\Reserve;
use App\Models\Review;
use App\Models\Shop;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Manager;

use Auth;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Validator;

class ShopController extends Controller
{
    public function shopAll() {
        $auth = Auth::user();
        $shops = Shop::all();
        $areas = Area::all();
        $genres = Genre::all();
        $reviews = Review::all();
        
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
        if(!is_null($auth)){
            $myReview = Review::where('user_id', $auth->id)
            ->where('shop_id', $request->id)
            ->first();
            return view('shop_detail', compact('requests', 'dt', 'auth', 'user', 'reviews', 'averageRatings', 'shopModal', 'myReview'));
        }
        
        elseif(empty($requests)) {
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
    
    public function csvImportPage() {
        return view('csvImport');
    }
    
    public function shopCreateAdmin(CsvRequest $request) {
        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file));
        
        $managerCount = Manager::count();
        
        foreach ($csvData as $key => $row) {
            if ($key === 0) {
                continue;
            }
            
            $data = [
                'manager_id' => $row[0],
                'area' => $row[1],
                'genre' => $row[2],
                'name' => $row[3],
                'description' => $row[4],
                'image_path' => $row[5],
            ];
            
            $validator = Validator::make($data, [
                'manager_id' => 'required|integer|min:1|max:' . $managerCount,
                'name' => 'required|string|max:50',
                'area' => 'required|in:東京都,大阪府,福岡県',
                'genre' => 'required|in:寿司,焼肉,イタリアン,居酒屋,ラーメン',
                'description' => 'required|string|max:400',
                'image_path' => 'required|url|ends_with:.jpeg,.png',
            ], [
                'manager_id.required' => '店舗管理者IDは必須です',
                'manager_id.integer' => '店舗管理者IDは数値である必要があります',
                'manager_id.min' => '店舗管理者IDは1以上である必要があります',
                'manager_id.max' => '入力された店舗管理者IDが存在しません',
                'name.required' => '店舗名は必須です',
                'name.max' => '店舗名は50文字以内で入力してください',
                'area.required' => 'エリアは必須です',
                'area.in' => 'エリアは「東京都」、「大阪府」、「福岡県」のいずれかを選択してください',
                'genre.required' => 'ジャンルは必須です',
                'genre.in' => 'ジャンルは「寿司」、「焼肉」、「イタリアン」、「居酒屋」、「ラーメン」のいずれかを選択してください',
                'description.required' => '店舗説明は必須です',
                'description.max' => '店舗説明は400文字以内で入力してください',
                'image_path.required' => '店舗画像は必須です',
                'image_path.url' => '店舗画像は正しいURL形式でなければなりません',
                'image_path.ends_with' => '店舗画像はjpegまたはpng形式でなければなりません',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $dir = 'image';
            $file_name = basename($data['image_path']);
            $file_path = public_path('storage/' . $dir . '/' . $file_name);
            
            if (@file_get_contents($data['image_path'])) {
                $imageContent = file_get_contents($data['image_path']);
                file_put_contents($file_path, $imageContent);
            } else {
                return redirect()->back()->withErrors('指定された画像URLが存在しません: ' . $data['image_path']);
            }
            
            $areaGenre = ShopController::areaGenreGet($data);
            
            $params = [
                'manager_id' => $data['manager_id'],
                'name' => $data['name'],
                'area_id' => $areaGenre['area'],
                'genre_id' => $areaGenre['genre'],
                'description' => $data['description'],
                'image_path' => 'storage/' . $dir . '/' . $file_name,
            ];
            
            Shop::create($params);
        }
        
        return view('thanks')->with('message', '店舗を作成しました。')->with('message1', 'ホーム');
    }
}