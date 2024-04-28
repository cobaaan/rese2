<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Shop;

use Auth;

use Carbon\Carbon;

class ReseController extends Controller
{
    public function done(){
        $shops = Shop::all();
        //dd($shops);
        return view('done', compact('shops'));
    }
}
