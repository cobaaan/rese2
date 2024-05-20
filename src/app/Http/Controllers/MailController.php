<?php

namespace App\Http\Controllers;

use Auth;

use App\Models\User;

use App\Http\Requests\MailRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function mailForm(Request $request) {
        $requests = $request->all();
        unset($requests['_token']);
        $auth = Auth::user();
        
        return view('mail_form', compact('requests', 'auth'));
    }
    
    public function sendMail(MailRequest $request) {
        $auth = Auth::user();
        
        $users = User::all();
        
        //dd($users);
        
        foreach($users as $user){
            Mail::send([], [], function ($message) use ($request, $user) {
                $message->to($user->email)
                ->subject($request['subject'])
                ->setBody($request['body']);
            });
        }
        /*
        Mail::send([], [], function ($message) use ($request) {
            $message->to($request['email'])
            ->subject($request['subject'])
            ->setBody($request['body']);
        });
        */
        return view('mail_sended', compact('auth'));
    }
}
