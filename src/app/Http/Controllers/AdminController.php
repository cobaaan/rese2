<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

use App\Http\Requests\AdminRequest;

use App\Models\User;

class AdminController extends Controller
{
    public function userAll() {
        $users = User::all();
        $auth = Auth::user();
        
        return view('user_all', compact('users', 'auth'));
    }
    
    public function adminRegister() {
        $auth = Auth::user();
        
        return view('admin_register', compact('auth'));
    }
}
