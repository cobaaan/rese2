<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;

use Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Manager;

use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class FortifyController extends Controller
{
    public function loginPage() {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::guard('manager')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/');
        } elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->intended('/');
        } elseif (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect('/');
        }
        
        return back()->withErrors([
            'email' => 'このメールアドレスは登録されていません。',
        ]);
    }
    
    public function logout(Request $request)
    {
        if (Auth::guard('manager')->check()) {
            Auth::guard('manager')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    public function adminRegister() {
        $auth = Auth::user();
        
        return view('admin_register', compact('auth'));
    }
    
    public function verify() {
        $auth = Auth::user();
        
        return view('auth/verify', compact('auth'));
    }
    
    public function adminCreate(AdminRequest $request) {
        $auth = Auth::user();
        $requests = $request->all();
        $dt = Carbon::now();
        
        if($request->role === 'user'){
            $user = User::create([
                'name' => $requests['name'],
                'email' => $requests['email'],
                'password' => Hash::make($requests['password']),
            ]);
        }
        else if($request->role === 'manager') {
            $user = Manager::create([
                'name' => $requests['name'],
                'email' => $requests['email'],
                'password' => Hash::make($requests['password']),
            ]);
        }
        else if($request->role === 'admin') {
            $user = Admin::create([
                'name' => $requests['name'],
                'email' => $requests['email'],
                'password' => Hash::make($requests['password']),
            ]);
        }
        
        return view('thanks', compact('auth'))->with('message', '新規ユーザーを登録しました。')->with('message1', 'ホーム');
    }
}