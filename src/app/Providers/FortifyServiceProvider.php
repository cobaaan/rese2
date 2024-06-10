<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;


use Auth;

class FortifyServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    */
    public function register(): void
    {
        //
    }
    
    /**
    * Bootstrap any application services.
    */
    public function boot(): void
    {
        
        Fortify::authenticateUsing(function (Request $request) {
            if (Auth::guard('manager')->attempt($request->only('email', 'password'))) {
                return Auth::guard('manager')->user();
            } elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
                return Auth::guard('admin')->user();
            } elseif (Auth::guard('web')->attempt($request->only('email', 'password'))) {
                return Auth::guard('web')->user();
            }
        });
        
        
        Fortify::createUsersUsing(CreateNewUser::class);
        
        Fortify::registerView(function () {
            return view('auth.register');
        });
        
        Fortify::loginView(function () {
            return view('auth.login');
        });
        
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            
            return Limit::perMinute(10)->by($email . $request->ip());
        });
        
        Fortify::verifyEmailView(function () {
            $auth = Auth::user();
            return view('auth.verify', compact('auth'));
        });
    }
}
