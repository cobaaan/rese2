<?php

namespace App\Http\Controllers;

use App\Models\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class FortifyController extends Controller
{
    public function adminCreate(Request $request) {
        $requests = $request->all();
        $dt = Carbon::now();
        
        $user = User::create([
            'role' => $requests['role'],
            'name' => $requests['name'],
            'email' => $requests['email'],
            'password' => Hash::make($requests['password']),
        ]);
        return redirect()->back()->with('success');
    }
    
    public function verify() {
        return view('auth/verify');
    }
}
