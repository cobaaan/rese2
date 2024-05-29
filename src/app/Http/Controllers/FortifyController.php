<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;

use Auth;

use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class FortifyController extends Controller
{
    public function adminCreate(AdminRequest $request) {
        $auth = Auth::user();
        $requests = $request->all();
        $dt = Carbon::now();
        
        $user = User::create([
            'role' => $requests['role'],
            'name' => $requests['name'],
            'email' => $requests['email'],
            'password' => Hash::make($requests['password']),
        ]);
        
        return view('thanks', compact('auth'))->with('massage', '新規ユーザーを登録しました。');
    }
    
    public function adminRegister() {
        $auth = Auth::user();
        
        return view('admin_register', compact('auth'));
    }

    public function verify() {
        $auth = Auth::user();
        
        return view('auth/verify', compact('auth'));
    }
}
