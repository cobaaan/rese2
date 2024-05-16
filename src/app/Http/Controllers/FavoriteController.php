<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Favorite;

class FavoriteController extends Controller
{
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
}
