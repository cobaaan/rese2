<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class AdminController extends Controller
{
    public function userAll() {
        $users = User::all();
        
        return view('user_all', compact('users'));
    }
    
    public function adminRegister() {
        return view('admin_register');
    }
}
