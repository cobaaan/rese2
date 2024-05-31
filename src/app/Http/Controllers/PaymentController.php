<?php

namespace App\Http\Controllers;

use Auth;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $auth = Auth::user();
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));
        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $request->amount,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return view('done', compact('auth'));
        }
        return view('thanks', compact('auth'))->with('massage', 'お支払いありがとうございます。');
    }
}
