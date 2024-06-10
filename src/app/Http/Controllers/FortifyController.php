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


class FortifyController extends Controller
{
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
            return redirect()->intended('/');
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
    
    
    
    public function adminCreate(AdminRequest $request) {
        $auth = Auth::user();
        $requests = $request->all();
        $dt = Carbon::now();
        
        switch ($request->role) {
            case 'user':
                $user = User::create([
                    'name' => $requests['name'],
                    'email' => $requests['email'],
                    'password' => Hash::make($requests['password']),
                ]);
                break;
                case 'manager':
                    $user = Manager::create([
                        'name' => $requests['name'],
                        'email' => $requests['email'],
                        'password' => Hash::make($requests['password']),
                    ]);
                    break;
                    case 'admin':
                        $user = Admin::create([
                            'name' => $requests['name'],
                            'email' => $requests['email'],
                            'password' => Hash::make($requests['password']),
                        ]);
                        break;
                    }
                    /*
                    $user = User::create([
                    'role' => $requests['role'],
                    'name' => $requests['name'],
                    'email' => $requests['email'],
                    'password' => Hash::make($requests['password']),
                    ]);
                    */
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
            